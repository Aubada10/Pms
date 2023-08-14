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

    public function admin_register(RegisterUserRequest $request)
    {
        //$image = ImageUpload::imageUpload($request->image,100,200,'profile/');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'role'=>'Admin',
            ]);
            $user->notify(new LogInNotification);
        return response()->json([
            'status'=>true,
            'message'=>'Admin created successfully',
            'id'=>$user->id,
            'token'=>$user->createToken('Api Token')->plainTextToken,
        ],200);;
    }


    public function user_register(RegisterUserRequest $request)
    {
        $image=null;
        if($request->has('image'))
        {
            $image = ImageUpload::imageUpload($request->image,100,200,'profile/');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'image'=>$image,
            'role'=>'User',
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
            $user = User::where([
                ['email',$request->email],
                ['role','Admin']
            ])->first();
            return response()->json([
                'status'=>true,
                 //'token'=>$user->createToken('Api token')->plainTextToken,
                'token'=>$user->createToken('auth_token')->plainTextToken,
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
            $user = User::where([
                ['email',$request->email],
                ['role','User']
            ])->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status'=>true,
                //'token'=>$user->createToken('Api token')->plainTextToken,
                'token'=>$user->createToken('auth_token')->plainTextToken,
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




    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }
    }
