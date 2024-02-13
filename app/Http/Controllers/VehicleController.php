<?php

namespace App\Http\Controllers;

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function getVehicleMakeData(): \Illuminate\Http\JsonResponse
    {
        $make = VehicleMake::all();
        return response()->json(['success' => true,'message' => 'Vehicle make list.','data' => ['make' => $make]]);
    }

    public function getVehicleModelData(Request $request): \Illuminate\Http\JsonResponse
    {
        $make = $request->get('make');
        $model = VehicleModel::where('make_id',$make)->get();
        return response()->json(['success' => true,'message' => 'Vehicle model list.','data' => ['model' => $model]]);
    }
}
