<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $request->validated();
        $created_user = User::create([

            'login' =>$request->login,
            'email'=>$request->email,
            'password' => bcrypt($request->password),

        ]);
        $created_user->save();
        return response()->json([
            'message' => 'Вы успешно зрегистрированы'

        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials))
        {
            return response()->json([
                'message'=>'Неверно указан пароль',
                'errors'=>'Unauthorised'
                ], 401);
        }

        /** @var User $user */
        $user =  Auth::user();
        $token = $user->createToken(config('app.name'));

        $token->token->expires_at = Carbon::now()->addDay();

        $token->token->save();

        return response()->json([
            'token_type' => 'Bearer',
            'token'=>$token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()

        ], 200);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' =>'Вы успешно вышли из системы'
        ], 200);

    }
}
