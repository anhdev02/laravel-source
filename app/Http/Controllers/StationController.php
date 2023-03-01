<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function getStation($id){
        $station = Station::where('route_id', $id)->get();
        return response()->json([
            'station' => $station,
        ]);
    }

    public function getTooltips(Request $request){
        $station = new Station;
        $station->station_name = $request->input('station_name');  
        $tooltips = Station::select('route_id')
        ->where('station_name', $station->station_name)
        ->get();
        return response()->json([
            'tooltips' => $tooltips,
        ]);
    }
}
