<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Actions\User\UserAction;
use App\Http\Requests\User\RegisterUserFormRequest;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterUserFormRequest $request, UserAction $action)
    {
        $user = $action->register($request);

        $token = auth()->login($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], 200);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|string|min:6',
        ]);

        $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($token) {
            return response()->json([
                'user' => auth()->user(),
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ], 200);
        }
    }

    public function logout()
    {
        // get token
        $token = JWTAuth::getToken();

        // invalidate token
        $invalidate = JWTAuth::invalidate($token);

        if($invalidate) {
            return response()->json([
                'message' => 'Successfully logged out',
            ], 200);
        }
    }

    public function profile()
    {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'data' => $user,
            ], 200);
        }
    }

    public function refresh()
    {
        return response()->json([
            'user' => auth()->user(),
            'token' => auth()->refresh(),
            'type' => 'Bearer',
        ]);
    }
}
