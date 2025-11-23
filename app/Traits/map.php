<?php

namespace App\Traits;

use GuzzleHttp\Client;


trait map
{


    public function getMap($lat, $long)
    {
        $client = new Client([
            'base_uri' => 'https://nominatim.openstreetmap.org',
            'headers' => [
                'User-Agent' => 'com.topbusiness.edarat',
                'Accept-Language' => app()->getLocale(),
            ],
        ]);

        $response = $client->get('/reverse', [
            'query' => [
                'lat' => $lat,
                'lon' => $long,
                'format' => 'json',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['display_name'] ?? null;
    }

}
