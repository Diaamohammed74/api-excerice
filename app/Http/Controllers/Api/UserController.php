<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $data['token']=$user->createToken("ApiExcercise")->plainTextToken;
        $data['user']=$user->name;
        return ApiResponse::sendResponse(201,"User Account Created Successfuly",$data);
    }
}
