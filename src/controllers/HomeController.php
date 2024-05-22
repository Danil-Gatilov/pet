<?php

namespace App\controllers;

use App\api\GismeteoApi;
class HomeController extends AbstractController
{
    public function index()
    {
        $api = new GismeteoApi();
        $response = json_decode($api->api(), true);
        $this->view('home', ['response' => $response]);
    }

}