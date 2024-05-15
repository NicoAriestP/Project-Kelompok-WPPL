<?php

namespace App\Actions\Comment;

use App\Http\Requests\Comment\CommentFormRequest;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CommentAction
{

    /**
     * Retrieves all comments for a task.
     *
     * @param Task $task The task to retrieve comments for.
     * @return Comment[] The comments for the task.
     */

    public function getComments(Task $task): array
    {
        return $task->comments()->with('user')->get()->toArray();
    }

    /**
     * Saves a new comment.
     *
     * @param CommentFormRequest $request The request object containing the validated comment data.
     * @return Comment The newly created comment.
     */
    public function save(CommentFormRequest $request, Task $task): Comment
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;

        return $task->comments()->create($validated);
    }

    /**
     * Updates an existing comment.
     *
     * @param Comment $comment The comment to be updated.
     * @param CommentFormRequest $request The request object containing the validated comment data.
     * @return Comment The updated comment.
     */
    public function update(Comment $comment, CommentFormRequest $request): Comment
    {
        $comment->update($request->validated());

        return $comment;
    }

    /**
     * Deletes a comment.
     *
     * @param Comment $comment The comment to be deleted.
     * @return void
     */
    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
