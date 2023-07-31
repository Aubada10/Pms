<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $shops=Shop::all();
        return response()->json([
            'status'=>true,
            'data'=>$shops
        ]);
    }
}
