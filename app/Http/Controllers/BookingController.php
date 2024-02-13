<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Slots;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBookings(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->get('date');
        $carbonDate = Carbon::parse($date);
        $slotQuery = Slots::query();
        //Get dates
        $dates = $slotQuery->select('slot_date')
            ->whereYear('slot_date','=',$carbonDate->format('Y'))
            ->groupBy('slot_date')->get()->pluck('slot_date')->toArray();

        //Get Bookings
        $booking = Slots::with(['customer','booking'])
            ->whereDate('slot_date','=',$carbonDate->format('Y-m-d'))
            ->where('is_booked','=',1)
            ->get();

        return response()->json(['success' => true, 'message' => 'Bookings','data' => ['dates' => $dates,'bookings' => $booking]]);
    }

    public function createSlots(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->get('date');
        if(!$date){
            return response()->json(['success' => false, 'message' => 'Date required','data' => []]);
        }
        //Since we already know the timings so hard coded here otherwise it will be dynamic
        $date .= '09:00';
        $currentTime = Carbon::parse($date);
        $slots = [];
        //17 intervals are there until it's 5.30PM
        foreach (range(0,17) as $interval){
            $minutesToAdd = 30 * $interval;
            $slotWithTime = clone $currentTime;
            $slots[] = $slotWithTime->addMinutes($minutesToAdd)->format('Y-m-d h:i A');
        }
        return response()->json(['success' => true, 'message' => 'Slots','data' => ['slots' => $slots]]);
    }

    public function saveSlots(Request $request): \Illuminate\Http\JsonResponse
    {
        $slots = $request->get('slots');
        if(!$slots){
            return response()->json(['success' => false, 'message' => 'Slots are required','data' => []]);
        }
        foreach($slots as $slot){
            //Save slots for the date
            $dbSlot = new Slots();
            $dbSlot->fill([
                'slot_date' => date('Y-m-d',strtotime($slot)),
                'slot_time' => date('H:i',strtotime($slot)),
                'is_booked' => 0,
                'disabled' => 0,
                'booked_by' => null
            ]);
            $dbSlot->save();
        }
        return response()->json(['success' => true, 'message' => 'Slots saved successfully.','data' => []]);
    }

    public function getSlotData(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->get('date');
        if(!$date){
            return response()->json(['success' => false, 'message' => 'Date is required','data' => []]);
        }
        $carbonDate = Carbon::parse($date);
        $slotQuery = Slots::query();
        $dates = $slotQuery->select('slot_date')
            ->whereYear('slot_date','=',$carbonDate->format('Y'))
            ->groupBy('slot_date')->get()->pluck('slot_date')->toArray();
        return response()->json(['success' => true, 'message' => 'Slots saved successfully.','data' => ['dates' => $dates]]);
    }

    public function getSlotsByDate(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->get('date');
        if(!$date){
            return response()->json(['success' => false, 'message' => 'Date is required','data' => []]);
        }
        $date = date('Y-m-d',strtotime($date));
        $slotQuery = Slots::query();
        $slotQuery->with(['customer']);
        $slots = $slotQuery->whereDate('slot_date','=',$date)->get();
        return response()->json(['success' => true, 'message' => 'Slots saved successfully.','data' => ['slots' => $slots]]);
    }
    public function updateSlotStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        $slotId = $request->get('slot_id');
        $slot = Slots::find($slotId);
        $slot->disabled = $request->get('status');
        $slot->save();
        return response()->json(['success' => true, 'message' => 'Slots updated successfully.','data' => []]);
    }
    public function saveBooking(Request $request): \Illuminate\Http\JsonResponse
    {
        $firstName = trim($request->get('first_name'));
        $lastName = trim($request->get('last_name'));
        $phone = trim($request->get('phone'));
        $makeId = trim($request->get('make_id'));
        $modelId = trim($request->get('model_id'));
        $slotId = trim($request->get('slot_id'));
        //Create customer
        $customer = new Customer();
        $customer->fill([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
        ]);
        $customer->save();
        $customerId = $customer->id;
        //Create booking and associate customer with it
        $booking = new Booking();
        $booking->fill([
            'customer_id' => $customerId,
            'make_id' => $makeId,
            'model_id' => $modelId,
            'slot_id' => $slotId,
        ]);
        $booking->save();
        //Update the slot meta
        $slot = Slots::find($slotId);
        $slot->is_booked = 1;
        $slot->booked_by = $customerId;
        $slot->save();
        return response()->json(['success' => true, 'message' => 'Booking saved successfully.','data' => []]);
    }
}
