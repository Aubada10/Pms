<?php

namespace App\Http\Controllers;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Http\Requests\CreateApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Utils\ImageUpload;

class ApartmentsController extends Controller
{
     /**
     * create apartment
     */
    public function create(CreateApartmentRequest $request, $office_id){
        $photo = ImageUpload::imageUpload($request->photo,200,200,'Apartment/');
        $apartment = Apartment::create([
            'photo' => $photo ,
            'size' =>$request->size ,
            'location' =>$request->location ,
            'price' => $request->price ,
            'view'=>$request->view ,
            'room_number'=>$request->room_number ,
            'bathrooms'=>$request->bathrooms,
            'cladding'=>$request->cladding,
            'floor'=>$request->floor,
            'property' =>$request->property ,
            'renting_period' =>$request->renting_period ,
            'type' =>$request->type,
            'contact_information' =>$request->phone_number,
            'user_id' => auth()->user()->id,
            'office_id' =>$office_id,
        ]);
        //response
        return response()->json([
            'status' => 1,
            'message' => 'apartment  created successfully',
            'data' => $apartment
        ]);
        }
    public function update(UpdateApartmentRequest $request, $id){

        if(Apartment::where([auth()->user()->id,'id' => $id])
        ->exists()){
            $Apartment = Apartment::find($id);
            $Apartment->photo = isset($request->photo) ? $request->photo : $Apartment->photo;
            $Apartment->size =  isset($request->size) ? $request->size : $Apartment->size;
            $Apartment->location = isset($request->location) ? $request->location : $Apartment->location;
            $Apartment->price =  isset($request->price) ? $request->price : $Apartment->price;
            $Apartment->view = isset($request->view) ? $request->view : $Apartment->view ;
            $Apartment->room_number = isset($request->room_number) ? $request->room_number : $Apartment->room_number ;
            $Apartment->bathrooms = isset($request->bathrooms) ? $request->bathrooms : $Apartment->bathrooms ;
            $Apartment->cladding = isset($request->cladding) ? $request->cladding : $Apartment->cladding ;
            $Apartment->floor = isset($request->floor) ? $request->floor : $Apartment->floor ;
            $Apartment->contact_information = isset($request->contact_information) ? $request->contact_information : $Apartment->phone_number ;
            $Apartment->property =  isset($request->property) ? $request->property : $Apartment->property;
            $Apartment->renting_period =  isset($request->renting_period) ? $request->renting_period : $Apartment->renting_period;
            $Apartment->type =  isset($request->type) ? $request->type: $Apartment->type;
            $Apartment->save();

            //response
            return response()->json([
                'status' => 1,
                'message' => 'apartment updated successfully',
            ]);

        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment is not exists',
            ]);
        }
    }

    public function delete($id){
        if(Apartment::where([auth()->user()->id,'id' => $id])
            ->exists())
            {
            $apartment = Apartment::find($id);
            $apartment->delete();

            //response
            return response()->json(
                [
                'status' => 1,
                'message' => 'apartment  deleted successfully',
            ]);
        }
        else
        {
            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment  is not exists',
            ]);
        }
    }

    public function show($id)
    {
        if(Apartment::where(['id' => $id
        ])->exists()){
            $apartment = Apartment::find($id);

            //response
            return response()->json([
                'status' => 1,
                'data' => $apartment
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'apartment  does not exist',
            ]);
        }
    }
    /**
     * publish an apartment from  to apartments table
     */
    public function publish($id){
        //don't forget the authontication
        $apartment = Apartment::find($id);
        if($apartment->type === 'renting'){
            if($apartment->photo != null && $apartment->size != null && $apartment->location != null && $apartment->price != null && $apartment->view != null && $apartment->room_number != null && $apartment->bathrooms != null && $apartment->cladding != null && $apartment->floor != null && $apartment->property == null && $apartment->renting_period != null && $apartment->phone_number != null ){
                $apartment = Apartment::create([
                    'photo' => $apartment->photo,
                    'size' => $apartment->size,
                    'location' =>$apartment->location,
                    'price' => $apartment->price,
                    'view'=> $apartment->view,
                    'room_number'=>$apartment->room_number,
                    'bathrooms'=>$apartment->bathrooms,
                    'cladding'=>$apartment->cladding,
                    'floor'=>$apartment->floor,
                    'renting_period' => $apartment->renting_period,
                    'type' => $apartment->type,
                    'contact_information' => $apartment->contact_information,
                    'user_id' => auth()->user()->id,
                    'office_id' =>$apartment->office_id
                ]);

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
                'message' => 'apartment is missing data',
            ]);
        }else{
            if($apartment->photo != null && $apartment->size != null && $apartment->location != null && $apartment->price != null && $apartment->view != null && $apartment->room_number != null && $apartment->bathrooms != null && $apartment->cladding != null && $apartment->floor != null && $apartment->property != null && $apartment->renting_period == null && $apartment->contact_information != null ){
                $apartment = Apartment::create([
                    'photo' => $apartment->photo,
                    'size' => $apartment->size,
                    'location' => $apartment->location,
                    'price' => $apartment->price,
                    'view'=> $apartment->view,
                    'room_number'=>$apartment->room_number,
                    'bathrooms'=>$apartment->bathrooms,
                    'cladding'=>$apartment->cladding,
                    'floor'=>$apartment->floor,
                    'property' => $apartment->property,
                    'type' => $apartment->type,
                    'contact_information' => $apartment->contact_information,
                    'user_id' => auth()->user()->id,
                    'office_id' =>$apartment->office_id,
                ]);

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
                'message' => 'apartment  is missing data',
            ]);
        }
    }

}
