<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users=User::where('role','=','User')->get();
        return response()->json([
            'status'=>true,
            'data'=>$users
        ]);
    }
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'the user deleted successfully'
        ]);
    }


    public function show(User $user)
    {
        return response()->json([
            'status'=>'true',
            'data'=>$user
        ]);
    }


    }
