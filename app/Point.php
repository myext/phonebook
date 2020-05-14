<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'id', 'city_id', 'condition_weather', 'icon', 'temperature', 'wind_speed'
    ];


    public function getTimeAttribute($value)
    {
        return date('Y/m/d H:i:s', $this->id);
    }
}
