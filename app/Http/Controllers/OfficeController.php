<?php

namespace App\Http\Controllers;

use App\Models\ApartmentDraft;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Http\Requests\OfficeRequest;


class OfficeController extends Controller
{
    /**
     * create an office
     */
    public function store/*create*/(OfficeRequest $request){
        //check if the user has already an office
        if(Office::where('user_id' ,auth()->user()->id)->exists()){
            //response
            return response()->json([
                'status' => 0,
                'message' => 'you already have an office',
            ]);

        }
        //store the logo if the user uploaded it
        if($request->logo) {
            $logoName = rand() . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads'), $logoName);
        }
         $path="/uploads";
        if(Office::where('name' , '=' , $request->name)->exists()){
            return response()->json([
                'succuss'=>false,
                'message'=>'office_name is already exist , please change the name'
            ],200);
        }
        //create office
        $office = Office::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'photo' => $path,
            'user_id' => auth()->user()->id
        ]);
        //response
        return response()->json([
            'status'=>true,
            'data'=>$office,
            'message'=>'the office created successfully'
        ],200);
    }

    /**
     * delete an office
     */
    public function delete($id){
        if(Office::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->exists()){
            $shopDraft = Office::find($id);
            $shopDraft->delete();

            //response
            return response()->json([
                'status' => 1,
                'message' => 'Office deleted successfully',
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'Office does not exist',
            ]);
        }
    }
    public function destroy(Office $office)
    {
        $office->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'the user deleted successfully'
        ]);
    }

    /**
     * show a specific office by sending the id of it
     */
    public function show($id){

        if(Office::where([
            'id' => $id
        ])->exists()){
            $office = Office::find($id);
            //response
            return response()->json([
                'status' => 1,
                'data' => $office
            ]);
        }else{
            //response
            return response()->json([
                'status' => 0,
                'message' => 'Office does not exist',
            ]);
        }
    }

    /**
     * List apartments that the an office have published
     */
    public function officeApartments($id){
        $office = Office::find($id);
        $apartments = $office->apartments;
        //response
        return response()->json([
            'status' => 1,
            'data' => $apartments
        ]);
    }

    /**
     * List shops that the an office have published
     */
    public function officeShops($id){
        $office = Office::find($id);
        $shops = $office->shops;
        //response
        return response()->json([
            'status' => 1,
            'data' => $shops
        ]);
    }

    /**
     * List apartments draft for the authonticated user that has an office
     */
    public function apartmentsDraft(){
        $office = Office::where('user_id', '=',  auth()->user()->id)->first();
        $aprtmentsDraft = $office->apartmentsDraft;
        //response
        return response()->json([
            'status' => 1,
            'data' => $aprtmentsDraft
        ]);
    }

    /**
     * List shops draft for the authonticated user that has an office
     */
    public function shopsDraft(){
        $office = Office::where('user_id', '=',  auth()->user()->id)->first();
        $shopsDraft = $office->shopsDraft;
        //response
        return response()->json([
            'status' => 1,
            'data' => $shopsDraft
        ]);
    }

    /**
     * List all offices
     */

    public function index/*listOffices*/(){
        $offices = Office::orderBy('name', 'ASC')->get();
        //response
        return response()->json([
            'status' => 1,
            'data' => $offices
        ]);
    }

    /**
     * Search for an office
     */
    public function searchOffice($name){
        $offices = Office::where('name', 'LIKE', "{$name}%")->get();
        //response
        return response()->json([
            'status' => 1,
            'data' => $offices
        ]);
    }

    /**
     * Rate an office
     */
    public function rateOffice($id,$rate){
        $office = Office::find($id);
        $office->rating = ($office->rating + $rate) / 2;
        $office->save();
        //response
        return response()->json([
            'status' => 1,
            'message' => 'office rated successfully'
        ]);
    }
}
