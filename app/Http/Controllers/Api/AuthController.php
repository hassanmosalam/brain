<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $req)
    {
        if (auth()->attempt($req->only(['email', 'password']))) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            return response()->json([
                'token' => $token,
                'status_code' => 200,
                'message' => "Login successfuly"
            ], 200);
        } else {
            return response()->json([
                'message' => "Error in username or password",
                'status_code' => 404,
            ], 404);
        }
    }


    public function register(Request $req)
    {
        try {

            $user = User::create([
                'full_name' => $req->full_name,
                'nick_name' => $req->nick_name,
                'email' => $req->email,
                'dob' => $req->dob,
                'pincode' => $req->pincode,
                'gender' => $req->gender,
                'mobile' => $req->mobile,
                'password' => Hash::make($req->password),
            ]);

            $token = $user->createToken('authToken')->accessToken;

            return response()->json([
                'token' => $token,
                'status_code' => 200,
                'message' => "Signed Up successfuly"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => "Error"
            ], 200);
        }
    }
}
