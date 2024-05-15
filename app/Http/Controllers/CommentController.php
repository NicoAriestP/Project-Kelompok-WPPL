<?php

namespace App\Http\Controllers;

use App\Actions\Comment\CommentAction;
use App\Http\Requests\Comment\CommentFormRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * CommentController class.
     *
     * This class is responsible for handling comments related operations.
     */
    public function __construct(
        protected CommentAction $commentAction
    ) {
    }

    public function index(Task $task)
    {
        try {
            $comments = $this->commentAction->getComments($task);
            return CommentResource::collection($comments);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Task $task, CommentFormRequest $request)
    {
        try {
            $comment = $this->commentAction->save($request, $task);
            return new CommentResource($comment);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Comment $comment, CommentFormRequest $request)
    {
        try {
            $comment = $this->commentAction->update($comment, $request);
            return new CommentResource($comment);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            $this->commentAction->delete($comment);
            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
