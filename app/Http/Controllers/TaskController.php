<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Actions\Task\TaskAction;
use App\Http\Requests\Task\TaskFormRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;

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

        $query = Task::query()
                ->tableFilter($request)
                ->orderBy($sort, $order)
                ->paginate($perPage);

        return TaskCollection::make($query);
    }

    // public function create(TaskFormRequest $request, TaskAction $action)
    // {
    //     $model = $action->save($request);

    //     if ($model) {
    //         return response()->json($model, 201);
    //     } else {
    //         return response()->json([
    //             'message' => 'Create Task Failed',
    //         ], 400);
    //     }
    // }

    // public function detail(Task $model)
    // {
    //     return TaskResource::make($model);
    // }

    // public function update(Task $model, TaskFormRequest $request, TaskAction $action)
    // {
    //     $model = $action->update($model, $request);

    //     if ($model){
    //         return response()->json($model, 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'Update Task Failed',
    //         ], 400);
    //     }
    // }

    // public function destroy(Task $model)
    // {
    //     $model->delete();

    //     if ($model){
    //         return response()->json(null, 204);
    //     } else {
    //         return response()->json([
    //             'message' => 'Delete Task Failed',
    //         ], 400);
    //     }
    // }
}
