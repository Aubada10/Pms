<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class BrokerController extends Controller
{
    public function index(){
        $brokers=User::where('role','=','Broker')->get();
        return response()->json([
            'data'=>$brokers
        ]);
    }
}
