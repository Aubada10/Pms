<?php

namespace App\Http\Controllers;

use App\Models\FollowOffice;
use App\Models\Notification;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\ShopDraft;
use App\Models\Shop;

class ShopsDraftController extends Controller
{
    /**
     * create shop draft
     */
    public function create(Request $request){
        $office = Office::where('user_id', 1/*auth()->user()->id*/)->first();
        if($office) {
            //create
            $shopDraft = ShopDraft::create([
                'photo' => isset($request->photo) ? $request->photo : null,
                'size' => isset($request->size) ? $request->size : null,
                'location' => isset($request->location) ? $request->location : null,
                'price' => isset($request->price) ? $request->price : null,
                'property' => isset($request->property) ? $request->property : null,
                'renting_period' => isset($request->renting_period) ? $request->renting_period : null,
                'type' => isset($request->type) ? $request->type : null,
                'contact_information' => isset($request->contact_information) ? $request->contact_information : null,
                'user_id' => 1,//auth()->user()->id
                'office_id' => $office->id
            ]);
            //response
            return response()->json([
                'status' => 1,
                'message' => 'shop draft created successfully',
                'data' => $shopDraft
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'please create an office first',
            ]);
        }
    }

    public function update(Request $request, $id){
        if($this->isAuthorized($id)) {
            if (ShopDraft::where([
                'id' => $id
            ])->exists()) {
                $shopDraft = ShopDraft::find($id);
                $shopDraft->photo = isset($request->photo) ? $request->photo : $shopDraft->photo;
                $shopDraft->size = isset($request->size) ? $request->size : $shopDraft->size;
                $shopDraft->location = isset($request->location) ? $request->location : $shopDraft->location;
                $shopDraft->price = isset($request->price) ? $request->price : $shopDraft->price;
                $shopDraft->property = isset($request->property) ? $request->property : $shopDraft->property;
                $shopDraft->renting_period = isset($request->renting_period) ? $request->renting_period : $shopDraft->renting_period;
                $shopDraft->type = isset($request->type) ? $request->type : $shopDraft->type;
                $shopDraft->contact_information = isset($request->contact_information) ? $request->contact_information : $shopDraft->contact_information;
                $shopDraft->save();

                //response
                return response()->json([
                    'status' => 1,
                    'message' => 'shop draft updated successfully',
                ]);

            } else {
                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'shop draft is not exists',
                ]);
            }
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'you are unauthorized',
            ]);
        }
    }

    public function delete($id){
        if($this->isAuthorized($id)) {
            if (ShopDraft::where([
                'id' => $id
            ])->exists()) {
                $shopDraft = ShopDraft::find($id);
                $shopDraft->delete();

                //response
                return response()->json([
                    'status' => 1,
                    'message' => 'shop draft delete successfully',
                ]);
            } else {
                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'shop draft is not exists',
                ]);
            }
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'you are unauthorized',
            ]);
        }
    }

    public function show($id){

        if(ShopDraft::where([
            'id' => $id
        ])->exists()){
            $shopDraft = ShopDraft::find($id);
            //response
            return response()->json([
                'status' => 1,
                'data' => $shopDraft
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'shop draft does not exist',
            ]);
        }
    }

    /**
     * publish a shop draft to shops table
     */
    public function publish($id){
        $shopDraft = ShopDraft::find($id);
        $office = Office::where('user_id', auth()->user()->id)->first();
        if($office->id == $shopDraft->office_id) {
            if ($shopDraft->type === 'renting') {
                if ($shopDraft->size != null && $shopDraft->location != null && $shopDraft->price != null && $shopDraft->property == null && $shopDraft->renting_period != null && $shopDraft->contact_information != null && $shopDraft->photo != null) {
                    $shop = Shop::create([
                        'photo' => $shopDraft->photo,
                        'size' => $shopDraft->size,
                        'location' => $shopDraft->location,
                        'price' => $shopDraft->price,
                        'renting_period' => $shopDraft->renting_period,
                        'type' => $shopDraft->type,
                        'contact_information' => $shopDraft->contact_information,
                        'user_id' => auth()->user()->id,
                        'office_id' => $shopDraft->office_id
                    ]);
                    //send notification to the users who follow this office
                    $users = FollowOffice::where('office_id', $shopDraft->office_id)->get('user_id');
                    $office = Office::find($shopDraft->office_id);
                    foreach($users as $user){
                        Notification::create([
                            'user_id' => $user['user_id'],
                            'body' => 'Office ' . $office->name . ' has published a new shop for renting'
                        ]);
                    }
                    //response
                    return response()->json([
                        'status' => 1,
                        'message' => 'shop draft have been published successfully',
                        'data' => $shop
                    ]);

                }
                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'shop draft is missing data',
                ]);
            } else {
                if ($shopDraft->size != null && $shopDraft->location != null && $shopDraft->price != null && $shopDraft->property != null && $shopDraft->renting_period == null && $shopDraft->contact_information != null && $shopDraft->photo != null) {
                    $shop = Shop::create([
                        'photo' => $shopDraft->photo,
                        'size' => $shopDraft->size,
                        'location' => $shopDraft->location,
                        'price' => $shopDraft->price,
                        'property' => $shopDraft->property,
                        'type' => $shopDraft->type,
                        'contact_information' => $shopDraft->contact_information,
                        'user_id' => auth()->user()->id,
                        'office_id' => $shopDraft->office_id
                    ]);

                    //send notification to the users who follow this office
                    $users = FollowOffice::where('office_id', $shopDraft->office_id)->get('user_id');
                    $office = Office::find($shopDraft->office_id);
                    foreach($users as $user){
                        Notification::create([
                            'user_id' => $user['user_id'],
                            'body' => 'Office ' . $office->name . ' has published a new shop for selling'
                        ]);
                    }

                    //response
                    return response()->json([
                        'status' => 1,
                        'message' => 'shop draft have been published successfully',
                        'data' => $shop
                    ]);

                }
                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'shop draft is missing data',
                ]);
            }
        }
        //response
        return response()->json([
            'status' => 0,
            'message' => 'you are unauthorized',
        ]);
    }
    public function isAuthorized($id){
        $shopDraft = ShopDraft::find($id);
        if(auth()->user()->id == $shopDraft->user_id)
            return true;
        return false;
    }
}
