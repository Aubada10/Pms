<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(){
        $apartments=Apartment::all();
        return response()->json([
            'status'=>true,
            'data'=>$apartments
        ]);
    }
}
