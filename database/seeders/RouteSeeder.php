<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('routes')->delete();
        DB::table('routes')->insert([
            ['id'=>1, 'route_name'=>'Tuyến số 1', 'start_time'=>'5:00', 'end_time'=>'21:00', 'length'=>19.7, 'min_price'=>12000, 'station_price'=>4000, 'total_station'=>14],
            ['id'=>2, 'route_name'=>'Tuyến số 2', 'start_time'=>'4:30', 'end_time'=>'21:00', 'length'=>9.1, 'min_price'=>10000, 'station_price'=>3000, 'total_station'=>14],
            ['id'=>5, 'route_name'=>'Tuyến số 5A', 'start_time'=>'5:30', 'end_time'=>'20:30', 'length'=>5.2, 'min_price'=>8000, 'station_price'=>2000, 'total_station'=>9]
        ]);
    }
}
