<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Land;
use App\Models\Shop;

class HomeController extends Controller
{
    public function index(){
        $users=User::where('role','=','User')->get()->count();
        $admins=User::where('role','=','Admin')->get()->count();
        $brokers=User::where('role','=','Broker')->get()->count();
        //$lands=Land::all()->count();
        $shops=Shop::all()->count();
        $apartments=Apartment::all()->count();
        $counts=[
    ['users' => $users],
    ['admins' => $admins],
    ['brokers' => $brokers],
    ['lands' => 0],
    ['apartments'=> $apartments],
    ['shops' => $shops],
];

    return response()->json([
        'status'=>true,
        'data'=>$counts
    ]);
    }

}
