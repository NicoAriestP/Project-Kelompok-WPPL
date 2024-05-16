<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\User\UserAction;
use App\Http\Requests\User\CreateUserFormRequest;
use App\Http\Requests\User\EditUserFormRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Get a list of Users with paging, sorting, and searching
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $search = $request->input('search', '');

        $user = auth()->user();

        $query = User::query()
            ->with('leader')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                }
            })
            ->where('leader_id', $user->id)
            ->orderBy($sort, $order)
            ->paginate($perPage);

        return UserCollection::make($query);
    }

    public function create(CreateUserFormRequest $request, UserAction $action)
    {
        $model = $action->save($request);

        if ($model) {
            return response()->json($model, 201);
        } else {
            return response()->json([
                'message' => 'Create User Failed',
            ], 400);
        }
    }

    public function detail(User $model)
    {
        return UserResource::make($model);
    }

    public function update(User $model, EditUserFormRequest $request, UserAction $action)
    {
        $model = $action->update($model, $request);

        if ($model) {
            return response()->json($model, 200);
        } else {
            return response()->json([
                'message' => 'Update User Failed',
            ], 400);
        }
    }

    public function destroy(User $model)
    {
        $model->delete();

        if ($model) {
            return response()->json(null, 204);
        } else {
            return response()->json([
                'message' => 'Delete User Failed',
            ], 400);
        }
    }

    public function get_subordinate(): UserCollection
    {
        $user = auth()->user();
        $subordinate = User::where('leader_id', $user->id)->with('subordinate')->get();

        return UserCollection::make($subordinate);
    }

    public function total_user(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $total = User::where('leader_id', $user->id)->count();

        return response()->json(['total' => $total]);

        // $loggedInUserId = auth()->user()->id;
        // $loggedInLeaderId = auth()->user()->leader_id;

        // $userCounts = \App\Models\User::selectRaw('GROUP_CONCAT(leaders.name SEPARATOR ", ") as leader_names, count(*) as total_users')
        //     ->leftJoin('users as leaders', 'leaders.id', '=', 'users.leader_id')
        //     ->where('users.leader_id', $loggedInLeaderId)
        //     ->orWhere('users.id', $loggedInUserId)
        //     ->groupBy('users.leader_id')
        //     ->get();

        // return response()->json($userCounts);
    }
}
