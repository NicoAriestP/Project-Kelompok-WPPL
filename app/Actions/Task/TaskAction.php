<?php

namespace App\Actions\Task;

use App\Http\Requests\Task\CreateTaskFormRequest;
use App\Http\Requests\Task\EditTaskFormRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

class TaskAction
{
	public function save(CreateTaskFormRequest $request): Task
	{
		DB::beginTransaction(); 

		try {
			$validated = $request->validated();

			$task = new Task($validated);

			$task->save();

			DB::commit(); 

			return $task;
			
		} catch (Throwable $error) {
			DB::rollback(); 

            throw $error; 
		}

	}

}