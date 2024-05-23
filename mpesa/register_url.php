<?php
$url = 'https:sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

$curl = curl_init();
$curl_setopt($curl, CURLOPT_URL, $url);
// Setting custom header
$curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ACCESS_TOKEN'));


$curl_post_data = array(
//Fill in the request parameters with valid values
'ShortCode' => '',
'ResponseType' => '',
'ConfirmationURL' => 'http://ip_address:port/confirmation',
'ValidationURL' => 'http://ip_address:port/validation_url'
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo $curl_response;

?>
