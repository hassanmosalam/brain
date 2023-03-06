<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendCodeRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerificationRequest;
use App\Http\Resources\ResendCodeRescource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserStatusResource;
use App\Http\Traits\CustomResponseTrait;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{

    public function login(Request $req)
    {
        if ($validationResponse = $this->isNotValidLogin($req))
            return $validationResponse;

        $token = auth()->user()->createToken('authToken')->accessToken;

        return $this->returnData(auth()->user()->withAccessToken($token));
    }


    public function register(Request $req)
    {
        try {

            $user = User::create([
                'first_name' => $req->first_name,
                'last_name' => $req->last_name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'mobile' => $req->mobile,
                'lang' => $req->lang,
                'status' => -1,
                'verification_code' => 1111,
            ]);


        } catch (Exception $e) {
        }
    }
}
