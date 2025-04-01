<?php
// get_address_suggestions.php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$apiKey = $_ENV['GOOGLE_MAPS_API_KEY'];

if (!$apiKey) {
    error_log("Google Maps API key not set in environment.");
    exit;
}

$query = $_GET['query']; // Get the search query from the client

// Central point in Noord-Holland (latitude and longitude of Amsterdam)
$location = "52.379189,4.899431"; // Latitude and longitude of Amsterdam
$radius = 50000; // Radius in meters (50 km)

$url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=" . urlencode($query) . 
       "&key=" . $apiKey . 
       "&components=country:nl" . 
       "&location=" . $location . 
       "&radius=" . $radius;

$response = file_get_contents($url); // Or use cURL

echo $response; // Return the JSON response to the client