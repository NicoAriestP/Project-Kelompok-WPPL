<?php

namespace App\Actions\User;

use App\Http\Requests\User\RegisterUserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
}