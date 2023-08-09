<?php

namespace App\Http\Controllers;

use App\Models\FollowOffice;
use App\Models\Office;
use Illuminate\Http\Request;

class FollowOfficeController extends Controller
{
    public function follow($id){
        $office = Office::find($id);
        if($office){
            FollowOffice::create([
                'office_id' => $office->id,
                'user_id' => auth()->user()->id
            ]);
            //response
            return response()->json([
                'status' => 1,
                'message' => 'you have followed the office'
            ]);
        }
        //response
        return response()->json([
            'status' => 0,
            'message' => 'office does not exist'
        ]);
    }
    public function unfollow($id){
        $office = Office::find($id);
        if($office && FollowOffice::where([
                'office_id' => $office->id,
                'user_id' => auth()->user()->id
            ])->exists()){
            FollowOffice::where([
                'office_id' => $office->id,
                'user_id' => auth()->user()->id
            ])->delete();
            //response
            return response()->json([
                'status' => 1,
                'message' => 'you have unfollowed the office'
            ]);
        }
        //response
        return response()->json([
            'status' => 0,
            'message' => 'office does not exist'
        ]);
    }
    public function myFollowedOffices(){
        $offices_ids = FollowOffice::where('user_id', auth()->user()->id)->get('office_id');
        $offices = Office::whereIn('id', $offices_ids)->get();
        //response
        return response()->json([
            'status' => 1,
            'data' => $offices
        ]);
    }
}
