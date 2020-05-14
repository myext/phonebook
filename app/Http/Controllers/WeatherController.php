<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Point;
use App\City;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherController extends Controller
{
    public function day($year = 1970, $month = 1, $day =1 )
    {
        $date = new \DateTime($year.'-'.$month.'-'.$day);

        $timestamp = $date->getTimestamp();

        $t_max = $timestamp + 86400;

        $points = Point::where('id', '>=' , $timestamp)
            ->where('id', '<' , $t_max)->get()->toArray();

        if(empty($points)) throw new NotFoundHttpException;

        $city_name = config('weather.city_name');

        for($i = 0; $i < count($points); $i++){
            $points[$i]['city_name'] = $city_name;
            $points[$i]['time'] = date('Y/m/d H:i:s', $points[$i]['id']);
        }

        return response()->json([
            'errors' => false,
            'data' => $points,
        ], 200);

    }
}
