<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request){
        $request->validate([
            'full_name' => 'required',
            'username' => 'required|min:3|unique:users,username|regex:/^[a-zA-Z0-9._]+$/',
            'password' => 'required|min:6'
        ]);


        $User = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => Hash::make( $request->password)
        ]);

        return response([
            'status' => 'success',
            'message' => 'User Registration Successful',
            'data' =>  $User,
            'token' => $User->createToken('register_tokens')->plainTextToken,
            'role' => 'User',
        ],201);
    }

public function Login(Request $request){
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);


    $User = User::where('username', $request->username)->first();
    if ($User && Hash::check($request->password, $User->password)) {
        return response([
            'status' => 'success',
            'message' => 'Login successful',
            'data' =>[
               'id' =>   $User->id,
                'username' =>$User->username,
                'created_at' => $User->created_at,
                'updated_at' => $User->updated_at,
                'token' => $User->createToken('login_tokens')->plainTextToken,
                'role' => 'user'
            ],

        ], 200);
    }


    $Admin = Administrator::where('username', $request->username)->first();
    if ($Admin && Hash::check($request->password, $Admin->password)) {
         return response([
            'status' => 'success',
            'message' => 'Login successful',
            'data' =>[
               'id' =>   $Admin->id,
                'username' =>$Admin->username,
                'created_at' => $Admin->created_at,
                'updated_at' => $Admin->updated_at,
                'token' => $Admin->createToken('login_tokens')->plainTextToken,
                'role' => 'admin'
            ],

        ], 200);
    }


    return response([
        'status' => 'authentication_failed',
        'message' => 'The username or password you entered is incorrect'
    ], 401);
}


    public function Logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        if(!$request){
            return response([
                'status' => 'Invalid Token',
                'message' => 'Invalid Or Expired Token'
            ],401);
        }

        return response([
            'status' => 'success',
            'message' => 'Logout successful'
        ],200);

    }
}
