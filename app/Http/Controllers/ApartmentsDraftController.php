<?php

namespace App\Http\Controllers;

use App\Models\ApartmentDraft;
use App\Models\Apartments;
use Illuminate\Http\Request;

class ApartmentsDraftController extends Controller
{
     /**
     * create shop draft
     */
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
            'floor'=>isset($request->floor)? $request->floor:null,
            'property' => isset($request->property) ? $request->property : null,
            'renting_period' => isset($request->renting_period) ? $request->renting_period : null,
            'type' => isset($request->type) ? $request->type: null,
            'contact_information' => isset($request->contact_information) ? $request->contact_information : null,
            'user_id' => 1 ,//auth()->user()->id
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
            'user_id' => 1, /*auth()->user()->id*/
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
            $ApartmentDraft->floor = isset($request->floor) ? $request->floor : $ApartmentDraft->floor ;
            $ApartmentDraft->contact_information = isset($request->contact_information) ? $request->contact_information : $ApartmentDraft->contact_information ;
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
            'user_id' => 1, /*auth()->user()->id*/
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
            if($apartmentDraft->photo != null && $apartmentDraft->size != null && $apartmentDraft->location != null && $apartmentDraft->price != null && $apartmentDraft->view != null && $apartmentDraft->room_number != null && $apartmentDraft->bathrooms != null && $apartmentDraft->cladding != null && $apartmentDraft->floor != null && $apartmentDraft->property == null && $apartmentDraft->renting_period != null && $apartmentDraft->contact_information != null ){
                $apartmentDraft = ApartmentDraft::create([
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
                    'user_id' => 1 ,//auth()->user()->id
                    'office_id' =>$apartmentDraft->office_id
                ]);

                 //response
                return response()->json([
                    'status' => 1,
                    'message' => 'appartment published created successfully',
                    'data' => $apartmentDraft
                ]);
            }

            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment draft is missing data',
            ]);
        }else{
            if($apartmentDraft->photo != null && $apartmentDraft->size != null && $apartmentDraft->location != null && $apartmentDraft->price != null && $apartmentDraft->view != null && $apartmentDraft->room_number != null && $apartmentDraft->bathrooms != null && $apartmentDraft->cladding != null && $apartmentDraft->floor != null && $apartmentDraft->property != null && $apartmentDraft->renting_period == null && $apartmentDraft->contact_information != null ){
                $apartment = ApartmentDraft::create([
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
