<?php

$consumerKey = '4AbfXSjw5Vwo1kWU96CfwskCVGPvrtY9AoRgXCSgRwk6fTI7';
$consumerSecret = 'SxGCe6OY4G2aIPa7Nvn8RTbkZS2wOU0QAp76SONvT8UxhKopOIU3KwHZKpdqEyqM';

$headers = ['Content-Type: application/json; charset=utf8'];

$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

// Initialize cURL session
$curl = curl_init($url);

// Set the necessary cURL options
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);

// Execute the cURL session
$result = curl_exec($curl);

// Check for execution errors
if ($result === false) {
    die("cURL error: " . curl_error($curl));
}

// Retrieve information about the cURL session
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($curl);

// Decode the JSON response
$result = json_decode($result);

// Extract the access token
if (isset($result->access_token)) {
    $access_token = $result->access_token;
    echo $access_token;
} else {
    die("Failed to get access token.");
}

?>
