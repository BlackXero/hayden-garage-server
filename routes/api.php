<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'],static function(){
    Route::post('/get-bookings',[BookingController::class,'getBookings']);
    Route::post('/create-slots',[BookingController::class,'createSlots']);
    Route::post('/get-slot-data',[BookingController::class,'getSlotData']);
    Route::post('/update-slot-status',[BookingController::class,'updateSlotStatus']);
    Route::post('/save-slots',[BookingController::class,'saveSlots']);
    Route::post('/save-booking',[BookingController::class,'saveBooking']);
    Route::post('/get-slots-by-date',[BookingController::class,'getSlotsByDate']);
    Route::post('/get-vehicle-make',[VehicleController::class,'getVehicleMakeData']);
    Route::post('/get-vehicle-model',[VehicleController::class,'getVehicleModelData']);
});

