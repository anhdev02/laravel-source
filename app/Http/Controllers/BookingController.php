<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking');
    }

    public function checking()
    {
        return view('checking');
    }

    public function fetchbooking(){
        $bookings = Booking::get();
        return response()->json([
            'bookings'=>$bookings,
        ]);
    }

    public function store(Request $request)
    {
        $booking = new Booking;
        $booking->route_name = $request->input('route_name');
        $booking->start_station = $request->input('start_station');
        $booking->end_station = $request->input('end_station');
        $booking->quantity = $request->input('quantity');
        $booking->phone = $request->input('phone');
        $booking->total = floatval($request->input('total'));
        $booking->save();
        return response()->json([
            'status' => 200,
            'message' => 'Đặt vé thành công !',
        ]);
    }

    public function getbooking($sdt){
        $bookings = Booking::where('phone', $sdt)->get();
        return response()->json([
            'bookings' => $bookings,
        ]);
    }
}
