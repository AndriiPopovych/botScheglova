<?php


//phpinfo();
//die();
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here

$header = [
];


$header[] = "Content-Type: application/json";


curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://graph.facebook.com/v2.6/me/messages?access_token=EAADWkR8VvcQBAEMMViwsZCXW6afeCIhbBQr2CXgseOO80lHHT7NvQ3JltUEuIrr9ZCMR01SsybFrOQGZCSRB9rgbHMG02Jj8FvZAhj03t9GnVxr2BuQ6avkB58auD5EhUoVXE7m1AbL3H0MxsJ1sAiZAVMLkJGqAdEYai31KZCiAZDZD',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => http_build_query(array(
        "recipient" => ["id" => 1102287203166782],
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
