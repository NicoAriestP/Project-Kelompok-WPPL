<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Task\TaskAction;
use App\Http\Requests\Task\CreateTaskFormRequest;
use App\Http\Requests\Task\EditTaskFormRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Enum\Task\StatusType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    /**
     * Get a list of Tasks with paging, sorting, and searching
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $user = auth()->user();

        if ($user->is_leader) {
            $query = Task::query()
                ->with(['category', 'pic'])
                ->tableFilter($request)
                ->where('created_by', $user->id)
                ->orderBy($sort, $order)
                ->paginate($perPage);
        } else {
            $query = Task::query()
                ->with(['category', 'pic'])
                ->tableFilter($request)
                ->where('pic_id', $user->id)
                ->orderBy($sort, $order)
                ->paginate($perPage);
        }

        return TaskCollection::make($query);
    }

    public function create(CreateTaskFormRequest $request, TaskAction $action)
    {
        $model = $action->save($request);

        if ($model) {
            return response()->json($model, 201);
        } else {
            return response()->json([
                'message' => 'Create Task Failed',
            ], 400);
        }
    }

    public function detail(Task $model)
    {
        $model->load(['pic', 'createdBy', 'category']);

        return TaskResource::make($model);
    }

    public function update(Task $model, EditTaskFormRequest $request, TaskAction $action)
    {
        $model = $action->update($model, $request);

        if ($model) {
            return response()->json($model, 200);
        } else {
            return response()->json([
                'message' => 'Update Task Failed',
            ], 400);
        }
    }

    public function destroy(Task $model)
    {
        $model->delete();

        if ($model) {
            return response()->json(null, 204);
        } else {
            return response()->json([
                'message' => 'Delete Task Failed',
            ], 400);
        }
    }

    public function deleteFile(Task $model)
    {
        $model->deleteTaskFile();

        return back(303)->with('status', 'file-deleted');
    }

    public function total_task_status(string $status): JsonResponse
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $taskCounts = \App\Models\Task::selectRaw('status, count(*) as total_tasks')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status', $status)
            ->groupBy('status')
            ->get();

        return response()->json([
            'data' => $taskCounts,
        ]);
    }

    public function summary(Request $request)
    {
        $status = $request->status;
        $priority = $request->priority;
        $effort = $request->effort;

        if (auth()->user()->is_leader) {
           $createdBy = auth()->user()->id;
        } else {
            $user = auth()->user()->load(['leader']);
            $createdBy = $user->leader->id;
        }

        $taskCount = Task::query()
            ->where(function ($query) use ($status) {
                if ($status) {
                    $query->where('status', $status);
                }
            })
            ->where(function ($query) use ($priority) {
                if ($priority) {
                    $query->where('priority', $priority);
                }
            })
            ->where(function ($query) use ($effort) {
                if ($effort) {
                    $query->where('effort', $effort);
                }
            })
            ->where('created_by', $createdBy)
            ->count();

        return response()->json([
            'totalTask' => $taskCount,
        ], 200);
    }

    public function monthlySummary(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)
            ->startOfDay()
            ->format('Y-m-d H:i:s'); 

        $endDate = Carbon::parse($request->end_date)
            ->endOfDay()
            ->format('Y-m-d H:i:s'); 

        if (auth()->user()->is_leader) {
           $createdBy = auth()->user()->id;
        } else {
            $user = auth()->user()->load(['leader']);
            $createdBy = $user->leader->id;
        }

        $openTaskCount = Task::query()
            ->where('status', StatusType::OPEN->value)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('created_by', $createdBy)
            ->count();

        $closedTaskCount = Task::query()
            ->where('status', StatusType::CLOSED->value)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('created_by', $createdBy)
            ->count();

        $resolvedTaskCount = Task::query()
            ->where('status', StatusType::RESOLVED->value)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('created_by', $createdBy)
            ->count();

        $inProgressTaskCount = Task::query()
            ->where('status', StatusType::IN_PROGRESS->value)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('created_by', $createdBy)
            ->count();

        $reopenTaskCount = Task::query()
            ->where('status', StatusType::REOPEN->value)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('created_by', $createdBy)
            ->count();

        return response()->json([
            'open' => $openTaskCount,
            'in_progress' => $inProgressTaskCount,
            'resolved' => $resolvedTaskCount,
            'closed' => $closedTaskCount,
            'reopen' => $reopenTaskCount,
        ], 200);
    }
}
