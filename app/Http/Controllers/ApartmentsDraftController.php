<?php

namespace App\Http\Controllers;

use App\Models\ApartmentDraft;
use App\Models\Apartment;
use App\Models\FollowOffice;
use App\Models\Notification;
use App\Models\Office;
use Illuminate\Http\Request;

class ApartmentsDraftController extends Controller
{
     /**
     * create shop draft
     */
    public function create(Request $request)
    {
        $office = Office::where('user_id', 1/*auth()->user()->id*/)->first();
        if ($office) {
            //create
            $apartmentDraft = ApartmentDraft::create([
                'photo' => isset($request->photo) ? $request->photo : null,
                'size' => isset($request->size) ? $request->size : null,
                'location' => isset($request->location) ? $request->location : null,
                'price' => isset($request->price) ? $request->price : null,
                'view' => isset($request->view) ? $request->view : null,
                'room_number' => isset($request->room_number) ? $request->room_number : null,
                'bathrooms' => isset($request->bathrooms) ? $request->bathrooms : null,
                'cladding' => isset($request->cladding) ? $request->cladding : null,
                'floor' => isset($request->floor) ? $request->floor : null,
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
                'message' => 'apartment draft created successfully',
                'data' => $apartmentDraft
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'please create an office first',
            ]);
        }
    }
    /**
     * update apartment draft
     */
    public function update(Request $request, $id){
        if($this->isAuthorized($id)) {
            if (ApartmentDraft::where([
                'id' => $id
            ])->exists()) {
                $ApartmentDraft = ApartmentDraft::find($id);
                $ApartmentDraft->photo = isset($request->photo) ? $request->photo : $ApartmentDraft->photo;
                $ApartmentDraft->size = isset($request->size) ? $request->size : $ApartmentDraft->size;
                $ApartmentDraft->location = isset($request->location) ? $request->location : $ApartmentDraft->location;
                $ApartmentDraft->price = isset($request->price) ? $request->price : $ApartmentDraft->price;
                $ApartmentDraft->view = isset($request->view) ? $request->view : $ApartmentDraft->view;
                $ApartmentDraft->room_number = isset($request->room_number) ? $request->room_number : $ApartmentDraft->room_number;
                $ApartmentDraft->bathrooms = isset($request->bathrooms) ? $request->bathrooms : $ApartmentDraft->bathrooms;
                $ApartmentDraft->cladding = isset($request->cladding) ? $request->cladding : $ApartmentDraft->cladding;
                $ApartmentDraft->floor = isset($request->floor) ? $request->floor : $ApartmentDraft->floor;
                $ApartmentDraft->contact_information = isset($request->contact_information) ? $request->contact_information : $ApartmentDraft->contact_information;
                $ApartmentDraft->property = isset($request->property) ? $request->property : $ApartmentDraft->property;
                $ApartmentDraft->renting_period = isset($request->renting_period) ? $request->renting_period : $ApartmentDraft->renting_period;
                $ApartmentDraft->type = isset($request->type) ? $request->type : $ApartmentDraft->type;
                $ApartmentDraft->save();

                //response
                return response()->json([
                    'status' => 1,
                    'message' => 'apartment draft updated successfully',
                ]);

            } else {
                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'apartment draft is not exists',
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

    /**
     * delete apartment draft
     */
    public function delete($id){
        if($this->isAuthorized($id)) {
            if (ApartmentDraft::where([
                'id' => $id
            ])->exists()) {
                $apartmentDraft = ApartmentDraft::find($id);
                $apartmentDraft->delete();

                //response
                return response()->json([
                    'status' => 1,
                    'message' => 'apartment draft deletede successfully',
                ]);
            } else {
                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'apartment draft is not exists',
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

    /**
     * get an apartment draft by its id
     */
    public function show($id){

        if(ApartmentDraft::where([
            'id' => $id
        ])->exists()){
            $apartmentDraft = ApartmentDraft::find($id);

            //response
            return response()->json([
                'status' => 1,
                'data' => $apartmentDraft
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment draft does not exist',
            ]);
        }
    }
    /**
     * publish an apartment from draft to apartments table
     */
    public function publish($id){
        $apartmentDraft = ApartmentDraft::find($id);
        $office = Office::where('user_id', auth()->user()->id)->first();
        if($office->id == $apartmentDraft->office_id){
            if($apartmentDraft->type === 'renting'){
                if($apartmentDraft->photo != null && $apartmentDraft->size != null && $apartmentDraft->location != null && $apartmentDraft->price != null && $apartmentDraft->view != null && $apartmentDraft->room_number != null && $apartmentDraft->bathrooms != null && $apartmentDraft->cladding != null && $apartmentDraft->floor != null && $apartmentDraft->property == null && $apartmentDraft->renting_period != null && $apartmentDraft->contact_information != null ){
                    $apartment = Apartment::create([
                        'photo' => $apartmentDraft->photo,
                        'size' => $apartmentDraft->size,
                        'location' => $apartmentDraft->location,
                        'price' => $apartmentDraft->price,
                        'view'=> $apartmentDraft->view,
                        'room_number'=>$apartmentDraft->room_number,
                        'bathrooms'=>$apartmentDraft->bathrooms,
                        'cladding'=>$apartmentDraft->cladding,
                        'floor'=>$apartmentDraft->floor,
                        'renting_period' => $apartmentDraft->renting_period,
                        'type' => $apartmentDraft->type,
                        'contact_information' => $apartmentDraft->contact_information,
                        'user_id' => auth()->user()->id,
                        'office_id' =>$apartmentDraft->office_id
                    ]);
                    //send notification to the users who follow this office
                    $users = FollowOffice::where('office_id', $apartmentDraft->office_id)->get('user_id');
                    $office = Office::find($apartmentDraft->office_id);
                    foreach($users as $user){
                        Notification::create([
                            'user_id' => $user['user_id'],
                            'body' => 'Office ' . $office->name . ' has published a new apartment for renting'
                        ]);
                    }

                    //response
                    return response()->json([
                        'status' => 1,
                        'message' => 'apartment published created successfully',
                        'data' => $apartment
                    ]);
                }

                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'apartment draft is missing data',
                ]);
            }else{
                if($apartmentDraft->photo != null && $apartmentDraft->size != null && $apartmentDraft->location != null && $apartmentDraft->price != null && $apartmentDraft->view != null && $apartmentDraft->room_number != null && $apartmentDraft->bathrooms != null && $apartmentDraft->cladding != null && $apartmentDraft->floor != null && $apartmentDraft->property != null && $apartmentDraft->renting_period == null && $apartmentDraft->contact_information != null ){
                    $apartment = Apartment::create([
                        'photo' => $apartmentDraft->photo,
                        'size' => $apartmentDraft->size,
                        'location' => $apartmentDraft->location,
                        'price' => $apartmentDraft->price,
                        'view'=> $apartmentDraft->view,
                        'room_number'=>$apartmentDraft->room_number,
                        'bathrooms'=>$apartmentDraft->bathrooms,
                        'cladding'=>$apartmentDraft->cladding,
                        'floor'=>$apartmentDraft->floor,
                        'property' => $apartmentDraft->property,
                        'type' => $apartmentDraft->type,
                        'contact_information' => $apartmentDraft->contact_information,
                        'user_id' => auth()->user()->id,
                        'office_id' =>$apartmentDraft->office_id
                    ]);

                    //send notification to the users who follow this office
                    $users = FollowOffice::where('office_id', $apartmentDraft->office_id)->get('user_id');
                    $office = Office::find($apartmentDraft->office_id);
                    foreach($users as $user){
                        Notification::create([
                            'user_id' => $user['user_id'],
                            'body' => 'Office ' . $office->name . ' has published a new apartment for selling'
                        ]);
                    }

                    //response
                    return response()->json([
                        'status' => 1,
                        'message' => 'apartment published created successfully',
                        'data' => $apartment
                    ]);
                }

                //response
                return response()->json([
                    'status' => 0,
                    'message' => 'apartment draft is missing data',
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
        $apartmentDraft = ApartmentDraft::find($id);
        if(auth()->user()->id == $apartmentDraft->user_id)
            return true;
        return false;
    }
}
