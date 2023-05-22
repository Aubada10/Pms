<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\ResetPasswordVerificationNotification;
use App\Http\Requests\Auth\ConfirmCodeRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Otp;

class ConfirmCodeController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }
    public function confirm_code(ConfirmCodeRequest $request){
        $otp2 = $this->otp->validate($request->email,$request->otp);
        if(! $otp2->status)
        {
            return response()->json([
                ['error' =>$otp2]
            ],401);
        }
        return response()->json([
            [
                'status' =>true,
                'email'=>$request->email
            ]
        ],200);
    }
}
