<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){
        $admins=User::where('role','=','Admin')->get();
        return response()->json([
            'data'=>$admins
        ]);
    }
}
