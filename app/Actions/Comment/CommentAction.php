<?php

namespace App\Actions\Comment;

use App\Http\Requests\Comment\CommentFormRequest;
use App\Models\Comment;
use App\Models\Task;

class CommentAction
{

    /**
     * Saves a new comment.
     *
     * @param CommentFormRequest $request The request object containing the validated comment data.
     * @return Comment The newly created comment.
     */
    public function save(CommentFormRequest $request, Task $task): Comment
    {
        return $task->comments()->create($request->validated());
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
