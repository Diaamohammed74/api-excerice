<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\FlareClient\Api;

class UserController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>['required','string','max:255'],
            'email'=>['required','email'],
            'password'=>['required','confirmed',Password::defaults()],
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422,"Registration Validation Errors",$validator->messages()->all());
        }
        $user= User::create(
            [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            ]);
        $data['token']=$user->createToken("ApiExcercise")->plainTextToken;
        $data['user']=$user->name;
        return ApiResponse::sendResponse(201,"User Account Created Successfuly",$data);
    }
    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>['required','email'],
            'password'=>['required'],
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422,"Login Validation Errors",$validator->errors());
        }
    if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
        $user=Auth::user();
        $data['token']=$user->createToken("LoginToken")->plainTextToken;
        $data['username']=$user->name;
        $data['email']=$user->email;
    return ApiResponse::sendResponse(200,"User Logged in Successfuly",$data);
    }
    return ApiResponse::sendResponse(401,"User Credintials doesn`t match ",[]);

}
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,"Logged out successfuly",[]);
    }
}
