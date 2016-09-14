<?php
/**
 * Created by PhpStorm.
 * User: Andrii
 * Date: 05.05.16
 * Time: 14:24
 */


$data =  file_get_contents("db/result.json");
//echo $data;

file_put_contents("db/result.json", "");


if ($data) {
$dataArr = json_decode($data);

$db = json_decode(file_get_contents("db/db.json"));

$db[] = $dataArr;

file_put_contents("db/db.json", json_encode($db));
}