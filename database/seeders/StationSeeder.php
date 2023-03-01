<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->delete();
        DB::table('stations')->insert([
            ['route_id'=>1, 'order'=>1, 'station_name'=>'Bến Thành'],
            ['route_id'=>1, 'order'=>2, 'station_name'=>'Nhà hát TP'],
            ['route_id'=>1, 'order'=>3, 'station_name'=>'Ba Son'],
            ['route_id'=>1, 'order'=>4, 'station_name'=>'Văn Thánh'],
            ['route_id'=>1, 'order'=>5, 'station_name'=>'Tân Cảng'],
            ['route_id'=>1, 'order'=>6, 'station_name'=>'Thảo Điền'],
            ['route_id'=>1, 'order'=>7, 'station_name'=>'An Phú'],
            ['route_id'=>1, 'order'=>8, 'station_name'=>'Rạch Chiếc'],
            ['route_id'=>1, 'order'=>9, 'station_name'=>'Phước Long'],
            ['route_id'=>1, 'order'=>10, 'station_name'=>'Bình Thái'],
            ['route_id'=>1, 'order'=>11, 'station_name'=>'Thủ Đức'],
            ['route_id'=>1, 'order'=>12, 'station_name'=>'Khu Công nghệ cao'],
            ['route_id'=>1, 'order'=>13, 'station_name'=>'Suối Tiên'],
            ['route_id'=>1, 'order'=>14, 'station_name'=>'BXMĐ mới'],
            ['route_id'=>2, 'order'=>1, 'station_name'=>'Bến Thành'],
            ['route_id'=>2, 'order'=>2, 'station_name'=>'Tao Đàn'],
            ['route_id'=>2, 'order'=>3, 'station_name'=>'Dân Chủ'],
            ['route_id'=>2, 'order'=>4, 'station_name'=>'Hòa Hưng'],
            ['route_id'=>2, 'order'=>5, 'station_name'=>'Lê Thị Riêng'],
            ['route_id'=>2, 'order'=>6, 'station_name'=>'Phạm Văn Hai'],
            ['route_id'=>2, 'order'=>7, 'station_name'=>'Bảy Hiền'],
            ['route_id'=>2, 'order'=>8, 'station_name'=>'Đồng Đen'],
            ['route_id'=>2, 'order'=>9, 'station_name'=>'Nguyễn Hồng Đào'],
            ['route_id'=>2, 'order'=>10, 'station_name'=>'Bà Quẹo'],
            ['route_id'=>2, 'order'=>11, 'station_name'=>'Phạm Văn Bạch'],
            ['route_id'=>2, 'order'=>12, 'station_name'=>'Tham Lương'],
            ['route_id'=>2, 'order'=>13, 'station_name'=>'Tân Thới Nhất'],
            ['route_id'=>2, 'order'=>14, 'station_name'=>'BX An Sương'],
            ['route_id'=>5, 'order'=>1, 'station_name'=>'Chợ Tân Bình'],
            ['route_id'=>5, 'order'=>2, 'station_name'=>'Bảy Hiền'],
            ['route_id'=>5, 'order'=>3, 'station_name'=>'Lăng Cha Cả'],
            ['route_id'=>5, 'order'=>4, 'station_name'=>'Hoàng Văn Thụ'],
            ['route_id'=>5, 'order'=>5, 'station_name'=>'Phú Nhuận'],
            ['route_id'=>5, 'order'=>6, 'station_name'=>'Nguyễn Văn Đậu'],
            ['route_id'=>5, 'order'=>7, 'station_name'=>'Bà Chiểu'],
            ['route_id'=>5, 'order'=>8, 'station_name'=>'Hàng Xanh'],
            ['route_id'=>5, 'order'=>9, 'station_name'=>'Tân Cảng']
        ]);
    }
}
