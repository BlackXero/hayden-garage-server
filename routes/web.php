<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $booking = \App\Models\Booking::with('slot')->first();
    $customer = \App\Models\Customer::first();
    //dd($booking,$customer);
    \Illuminate\Support\Facades\Mail::to('ankeshhimesh@gmail.com')->send(new \App\Mail\BookingConfirmationAdmin($booking,$customer));
});

