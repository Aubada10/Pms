<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function counts(){
        $users=User::where('role','=','User')->get()->count();
        $admins=User::where('role','=','Admin')->get()->count();
        $brokers=User::where('role','=','Broker')->get()->count();
        $lands=0;
        $apartments=0;
        $shops=0;

        return response()->json([
            'status'=>true,
            'data'=>[
                'users'=>$users,
                'admins'=>$admins,
                'brokers'=>$brokers,
                'lands'=>$lands,
                'apartments'=>$apartments,
                'shops'=>$shops,
            ]
        ]);
    }
    public function get_users(){
        $users=User::all();
        return response()->json([
            'data'=>$users
        ]);
    }
}
