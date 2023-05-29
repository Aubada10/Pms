<?php

namespace App\Http\Controllers;

use App\Models\ApartmentDraft;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentsDraftController extends Controller
{
    public function create(Request $request, $office_id){
        //create
        $apartmentDraft = ApartmentDraft::create([
            'photo' => isset($request->photo) ? $request->photo : null,
            'size' => isset($request->size) ? $request->size : null,
            'location' => isset($request->location) ? $request->location : null,
            'price' => isset($request->price) ? $request->price : null,
            'view'=>isset($request->view) ?$request->view :null,
            'room_number'=>isset($request->room_number)? $request->room_number :null,
            'bathrooms'=>isset($request->bathrooms)? $request->bathrooms:null,
            'cladding'=>isset($request->cladding)?$request->cladding:null,
            'floor_number'=>isset($request->floor_number)? $request->floor_number:null,
            'property' => isset($request->property) ? $request->property : null,
            'renting_period' => isset($request->renting_period) ? $request->renting_period : null,
            'type' => isset($request->type) ? $request->type: null,
            'phone_number' => isset($request->phone_number) ? $request->phone_number : null,
            'user_id' => auth()->user()->id,
            'office_id' =>$office_id
        ]);
        //response
        return response()->json([
            'status' => 1,
            'message' => 'appartment draft created successfully',
            'data' => $apartmentDraft
        ]);
        }

    public function update(Request $request, $id){

        if(ApartmentDraft::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->exists()){
            $ApartmentDraft = ApartmentDraft::find($id);
            $ApartmentDraft->photo = isset($request->photo) ? $request->photo : $ApartmentDraft->photo;
            $ApartmentDraft->size =  isset($request->size) ? $request->size : $ApartmentDraft->size;
            $ApartmentDraft->location = isset($request->location) ? $request->location : $ApartmentDraft->location;
            $ApartmentDraft->price =  isset($request->price) ? $request->price : $ApartmentDraft->price;
            $ApartmentDraft->view = isset($request->view) ? $request->view : $ApartmentDraft->view ;
            $ApartmentDraft->room_number = isset($request->room_number) ? $request->room_number : $ApartmentDraft->room_number ;
            $ApartmentDraft->bathrooms = isset($request->bathrooms) ? $request->bathrooms : $ApartmentDraft->bathrooms ;
            $ApartmentDraft->cladding = isset($request->cladding) ? $request->cladding : $ApartmentDraft->cladding ;
            $ApartmentDraft->floor_number = isset($request->floor_number) ? $request->floor_number : $ApartmentDraft->floor_number ;
            $ApartmentDraft->phone_number = isset($request->phone_number) ? $request->phone_number : $ApartmentDraft->phone_number ;
            $ApartmentDraft->property =  isset($request->property) ? $request->property : $ApartmentDraft->property;
            $ApartmentDraft->renting_period =  isset($request->renting_period) ? $request->renting_period : $ApartmentDraft->renting_period;
            $ApartmentDraft->type =  isset($request->type) ? $request->type: $ApartmentDraft->type;
            $ApartmentDraft->save();

            //response
            return response()->json([
                'status' => 1,
                'message' => 'apartment draft updated successfully',
            ]);

        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment draft is not exists',
            ]);
        }
    }

    public function delete($id){
        if(ApartmentDraft::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->exists()){
            $apartmentDraft = ApartmentDraft::find($id);
            $apartmentDraft->delete();

            //response
            return response()->json([
                'status' => 1,
                'message' => 'apartment draft deleted successfully',
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment draft is not exists',
            ]);
        }
    }

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
        //don't forget the authontication
        $apartmentDraft = ApartmentDraft::find($id);
        if($apartmentDraft->type === 'renting'){
            if($apartmentDraft->photo != null && $apartmentDraft->size != null && $apartmentDraft->location != null && $apartmentDraft->price != null && $apartmentDraft->view != null && $apartmentDraft->room_number != null && $apartmentDraft->bathrooms != null && $apartmentDraft->cladding != null && $apartmentDraft->floor_number != null && $apartmentDraft->property == null && $apartmentDraft->renting_period != null && $apartmentDraft->phone_number != null ){
                $apartment = Apartment::create([
                    'photo' => $apartmentDraft->photo,
                    'size' => $apartmentDraft->size,
                    'location' => $apartmentDraft->location,
                    'price' => $apartmentDraft->price,
                    'view'=> $apartmentDraft->view,
                    'room_number'=>$apartmentDraft->room_number,
                    'bathrooms'=>$apartmentDraft->bathrooms,
                    'cladding'=>$apartmentDraft->cladding,
                    'floor_number'=>$apartmentDraft->floor_number,
                    'renting_period' => $apartmentDraft->renting_period,
                    'type' => $apartmentDraft->type,
                    'phone_number' => $apartmentDraft->phone_number,
                    'user_id' => 1 ,//auth()->user()->id
                    'office_id' =>$apartmentDraft->office_id
                ]);

                 //response
                return response()->json([
                    'status' => 1,
                    'message' => 'appartment published created successfully',
                    'data' => $apartment
                ]);
            }

            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment draft is missing data',
            ]);
        }else{
            if($apartmentDraft->photo != null && $apartmentDraft->size != null && $apartmentDraft->location != null && $apartmentDraft->price != null && $apartmentDraft->view != null && $apartmentDraft->room_number != null && $apartmentDraft->bathrooms != null && $apartmentDraft->cladding != null && $apartmentDraft->floor_number != null && $apartmentDraft->property != null && $apartmentDraft->renting_period == null && $apartmentDraft->phone_number != null ){
                $apartment = Apartment::create([
                    'photo' => $apartmentDraft->photo,
                    'size' => $apartmentDraft->size,
                    'location' => $apartmentDraft->location,
                    'price' => $apartmentDraft->price,
                    'view'=> $apartmentDraft->view,
                    'room_number'=>$apartmentDraft->room_number,
                    'bathrooms'=>$apartmentDraft->bathrooms,
                    'cladding'=>$apartmentDraft->cladding,
                    'floor_number'=>$apartmentDraft->floor_number,
                    'property' => $apartmentDraft->property,
                    'type' => $apartmentDraft->type,
                    'phone_number' => $apartmentDraft->phone_number,
                    'user_id' => 1 ,//auth()->user()->id
                    'office_id' =>$apartmentDraft->office_id
                ]);

                 //response
                return response()->json([
                    'status' => 1,
                    'message' => 'appartment published created successfully',
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

}
