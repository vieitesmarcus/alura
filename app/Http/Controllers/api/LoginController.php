<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function doLogin(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
//        dd($credentials);
        $user = User::whereEmail($credentials['email'])->first();
        if(Auth::attempt($credentials) === false){
            return response()->json("Unauthorized", 401);
        }
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('token');
        return response()->json($token->plainTextToken, 200);
    }
}
