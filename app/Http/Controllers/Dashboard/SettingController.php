<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\ImageUpload;
use App\Models\Setting;
use App\Http\Requests\SettingRequest;
//use Hamcrest\Core\Set;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::all();

        return response()->json([
            'status'=>true,
            'data'=>$setting
        ]);
    }
    public function edit(Request $request, $id)
    {
        $setting = Setting::where('id', '=', $id)->first();
        $logo = ImageUpload::imageUpload($request->logo, 100, 100, 'logo/');
        $setting->update([
            'logo' => $logo,
            'name' => $request->name
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Setting updated successfully',
        ], 200);;
    }
}
