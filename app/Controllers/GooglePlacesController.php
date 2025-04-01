<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class GooglePlacesController extends ResourceController
{
    public function getAddressSuggestions()
    {
        $apiKey = getenv('GOOGLE_MAPS_API_KEY'); // Fetch API key from .env
        if (!$apiKey) {
            return $this->respond(['error' => 'Google Maps API key not set.'], 500);
        }

        $query = $this->request->getGet('query'); // Get input query
        if (!$query) {
            return $this->respond(['error' => 'No query provided.'], 400);
        }

        $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=" . urlencode($query) . "&key=" . $apiKey . "&components=country:nl";

        $response = file_get_contents($url); // Fetch data from Google API

        if ($response === false) {
            return $this->respond(['error' => 'Failed to fetch data from Google API.'], 500);
        }

        return $this->response->setContentType('application/json')->setBody($response);
    }
}
