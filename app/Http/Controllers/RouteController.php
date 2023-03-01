<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(){
        return view('home');
    }

    public function fecthroute(){
        $routes = Route::get();
        return response()->json([
            'routes'=>$routes,
        ]);
    }

    public function getRoute($id){
        $route = Route::find($id);
        return response()->json([
            'route' => $route,
        ]);
    }
}
