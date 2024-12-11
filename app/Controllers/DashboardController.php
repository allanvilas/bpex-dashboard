<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class DashboardController extends BaseController {

    use ResponseTrait;
    
    public function getData()
    {
        // Load the HTTP Client
        $client = \Config\Services::curlrequest();

        // Make a GET request
        $response = $client->get(env('EXTRACTOR_ENDPOINT_URL'), [
            'headers' => [
                'Authorization' => env('EXTRACTOR_API_KEY'),
                'Accept'        => 'application/json',
            ],
        ]);

        // Return the API response as JSON
        return $response->getBody();
    }

    public function dashboardMainPage() {

        $apiData = json_decode($this->getData(), true, 512, JSON_THROW_ON_ERROR);

        return view('pages/dashboardIndex', [
            'title' => 'Dashboard',
            'data' => $apiData ?? null,
        ]);
    }

}