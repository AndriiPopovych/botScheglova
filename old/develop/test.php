<?php


phpinfo();
die();
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here

$header = [
];


$header[] = "Content-Type: application/json";


curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAXBJEfVHnoBAGTlIyAqVbEYy4bXpqkDTokO1FiZADoYDQSZC43eI4lFkfKz2q8gidlM7nIdrt9tA5Aybq906AQMV3uchpAYbAnSUtm1qVsg4ZAFW4Jxzh9HZAeKrJozkcUEOfgA0AD1rZCLGHIRlD7OocGtabKZCccw8QWuDYswZDZD',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => http_build_query(array(
        "recipient" => ["id" => 10052765362358000],
        "message" => ['text' => "hello"]
    ))
));

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