<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $table = 'routes';
    protected $fillable = [
        'route_name',
        'start_time',
        'end_time',
        'length',
        'min_price',
        'station_price',
        'total_station',
    ];
}
