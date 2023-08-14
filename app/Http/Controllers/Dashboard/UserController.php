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
    public function lands_for_user(User $user){
        $lands=$user->lands();
        return response()->json([
            'status'=>'true',
            'data'=>$lands
        ]);
    }
    public function shops_for_user(User $user){
        $shops=$user->shops();
        return response()->json([
            'status'=>'true',
            'data'=>$shops
        ]);
    }
    public function apartments_for_user($id){
        $user=User::where('id','=',$id)->with('apartments')->get();
        dd($user);
    $apartments=$user->apartments();

    return response()->json([
        'status'=>'true',
        'data'=>$apartments
    ]);
    }
}
