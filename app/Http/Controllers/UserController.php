<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserController extends Controller
{
//    create user
    function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required',
                'email'    => 'required|email|unique:users',
                'password' => 'required',
            ]);

            User::create($request->all());
            return response()->json(['message' => 'User registered successfully.'], 200);
        }catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    function login(Request $request){
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required'
            ]);
            $user = User::where('email', '=', $request->input('email'))
                ->where('password', '=', $request->input('password'))->first();
            if ($user !== null){
                $token = JWTToken::encode($user->email, $user->id);
                return response()->json(['status'=>'success', 'message'=>'user login successful','token' => $token], 200);
            }
            else{
                return response()->json(['status'=>'failed', 'message'=>'user not found'], 401);
            }
        }catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }



//    End
}
