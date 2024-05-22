<?php


namespace App\api;


class GismeteoApi
{
    public function api()
    {

        $headers = [
            'X-Gismeteo-Token: 56b30cb255.3443075',
        ];

        $data = [
            'lat' => '55.7504461',
            'lon' => '37.6174943',
            'appid' => 'ebc0906eccf565989ecdf24e222e5af4'
        ];

        $params = http_build_query($data);

        $curl = curl_init();
        //$curl = curl_init("http://api.openweathermap.org/geo/1.0/direct?q=Moscow&appid=ebc0906eccf565989ecdf24e222e5af4");

        curl_setopt($curl, CURLOPT_URL, 'https://api.openweathermap.org/data/2.5/weather?' . $params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            $result = 'Curl error: ' . $err;
        } else {
            $result = $response;
        }

        return $result;
    }
}