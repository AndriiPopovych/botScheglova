<?php 

$curl = curl_init();
// Set some options - we are passing in a useragent too here

$header = [
];


$header[] = "Content-Type: application/json";


curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=EAAXBJEfVHnoBABIxsO42uhBTQHUv7bKm15bFpmcwwjsgegy4J8F5TndddStuKHRqUZCgC6nNVUVzKzc9a9P6vqpQkhfPyWjaQWTBBNuA7uXE2ZAsnIIyUSVSN1XIU9XUXmFk5uPP1A3v0E2AfNbaTMeFUtkppVK82t5JuBdQZDZD',
    CURLOPT_POST => 1
    ));


$header = [
];


$header[] = "Content-Type: application/json";


curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
// Send the request & save response to $resp
$resp = curl_exec($curl);

$response = curl_getinfo($curl);
echo '<pre>';
print_r($response);

var_dump($resp);

echo curl_error($curl);

// Close request to clear up some resources
curl_close($curl);