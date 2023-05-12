<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\LogInRequest;
use App\Notifications\LogInNotification;
use App\Helpers\ResponseFormatter;




class AuthController extends Controller
{

    public function register_user(RegisterUserRequest $request)
    {
        $image = ImageUpload::imageUpload($request->image,100,200,'profile/');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'image'=>$image,
            ]);
            $user->notify(new LogInNotification);
        return response()->json([
            'status'=>true,
            'message'=>'User created successfully',
            'id'=>$user->id,
            'token'=>$user->createToken('Api Token')->plainTextToken,
        ],200);;
    }
    public function admin_login(LogInRequest $request)
    {
            if(!Auth::attempt($request->only(['email','password'])))
            {
                /* return response()->json([
                    'status'=>false,
                    'message'=>'email or password does not match ,',
                    ''=>$request->errors(),
                ],401);*/
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }
            $user = User::where('email', $request->email,'role','admin')->first();
            return response()->json([
                'status'=>true,
                'token'=>$user->createToken('Api Token')->plainTextToken,
                'role'=>$user->role,
                'id'=>$user->id
            ],200);
        }
        public function user_login(LogInRequest $request)
    {
            if(!Auth::attempt($request->only(['email','password'])))
            {
                /* return response()->json([
                    'status'=>false,
                    'message'=>'email or password does not match ,',
                    ''=>$request->errors(),
                ],401);*/
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }
            $user = User::where('email', $request->email,'role','user')->first();
            return response()->json([
                'status'=>true,
                'token'=>$user->createToken('Api Token')->plainTextToken,
                'role'=>$user->role,
                'id'=>$user->id
            ],200);
        }
        public function broker_login(LogInRequest $request)
    {
            if(!Auth::attempt($request->only(['email','password'])))
            {
                /* return response()->json([
                    'status'=>false,
                    'message'=>'email or password does not match ,',
                    ''=>$request->errors(),
                ],401);*/
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }
            $user = User::where('email', $request->email,'role','broker')->first();
            return response()->json([
                'status'=>true,
                'token'=>$user->createToken('Api Token')->plainTextToken,
                'role'=>$user->role,
                'id'=>$user->id
            ],200);
        }
        public function logout(Request $request)
        {
            $user = $request->user();
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' =>'logout successfully',
            ]);
        }
    }
