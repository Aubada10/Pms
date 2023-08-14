<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Land;
use Illuminate\Http\Request;

class LandController extends Controller
{
    public function index(){
        $lands=Land::all();
        return response()->json([
            'status'=>true,
            'data'=>$lands
        ]);
    }
    public function destroy(Land $land)
    {
        $land->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'the user deleted successfully'
        ]);
    }
}
