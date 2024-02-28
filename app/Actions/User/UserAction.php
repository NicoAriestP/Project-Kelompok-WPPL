<?php

namespace App\Actions\User;

use App\Http\Requests\User\RegisterUserFormRequest;
use App\Http\Requests\User\CreateUserFormRequest;
use App\Http\Requests\User\EditUserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;
use Spatie\QueueableAction\QueueableAction;
use Throwable; 

class UserAction 
{
	public function register(RegisterUserFormRequest $request) : User
	{
		$validated = $request->validated();

		$validated['password'] = bcrypt($validated['password']);

		$user = new User($validated);

		$user->save();

		return $user;
	}

	public function save(CreateUserFormRequest $request): User
    {
        DB::beginTransaction(); 

        try {

            $validated = $request->validated();

            $validated['password'] = bcrypt($validated['password']);

            $model = new User($validated);

            $model->save();
            
            DB::commit(); 

            return $model;

        } catch (Throwable $error) {
        	
            DB::rollback(); 
            throw $error; 
        }
    }

    public function update(User $model, EditUserFormRequest $request): User
    {
        $validated = $request->validated();

        if (isset($request->password)) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $model->fill($validated);
        $model->save();

        return $model;
    }
}