<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\ResetPasswordVerificationNotification;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function __construct(){}
    public function reset_password(ResetPasswordRequest $request){
        $email=$request->email;
        $user = User::where('email',$email)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();
        $success['success'] = true;
        return response()->json($success,200);
    }
}
