<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $city_id = config('weather.city_id'); // Minsk city code
        $appid = config('weather.appid'); // api user code

        $params = http_build_query([
            'id' => $city_id,
            'appid' => $appid,
            'lang' => 'ru',
            'units' => 'metric',

        ], '', '&');

        $url = 'https://api.openweathermap.org/data/2.5/forecast?'.$params;

        $opts = [
            'http' => [
                'header' => "Content-type: application/json; charset=utf-8\r\n",
                'method' => "GET",
                'content' => '',
            ]
        ];

        $context = stream_context_create($opts);

        try{
            $fp = fopen($url, "r", false, $context);
            $answer = json_decode(stream_get_contents($fp), true);

        }catch ( \Exception $exception ){
                Log::error('Ошибка получения прогноза');
                Log::error($exception->getMessage());
                exit();
        }

        $data = [];

        foreach($answer['list'] as $key => $item){
            $data[$key]['id']                 = $item['dt'];
            $data[$key]['city_id']            = $city_id;
            $data[$key]['condition_weather']  = $item['weather'][0]['description'];
            $data[$key]['icon']               = $item['weather'][0]['icon'];
            $data[$key]['temperature']        = $item['main']['temp'];
            $data[$key]['wind_speed']         = $item['wind']['speed'];
        }

        $pdo = DB::connection()->getPdo();

        $stmt = $pdo->prepare('
        INSERT INTO points (id, city_id, condition_weather, icon, temperature, wind_speed, created_at, updated_at )
        VALUES
        (:id, :city_id, :condition_weather, :icon, :temperature, :wind_speed, now(), now())
        ON DUPLICATE KEY UPDATE
        condition_weather = VALUES(condition_weather),
        icon = VALUES(icon),
        temperature = VALUES(temperature),
        wind_speed = VALUES(wind_speed),
        updated_at = now()
        ');

        foreach ($data as $item){
            $stmt->execute($item);
        }

        Log::info('Погода обновлена');
    }



}
