<?php
/**
 * Created by PhpStorm.
 * User: Andrii
 * Date: 07.05.16
 * Time: 12:09
 */

error_reporting(3);

ini_set('precision',29);
$results = json_decode(file_get_contents("php://input"), true);

$id = $results[0];
$fares = $results[1];
$mainSumm = $results[2];
$secondarySumm = $results[3];


/**
 * @var Data
 */
$data = $results[4];



function __autoload($className) {
    //$className = preg_replace("/pimax\\\\/", "$1", $className);
    include $className.".php";
}



use Messages\Message;
use Messages\MessageButton;
use Messages\StructuredMessage;
use Messages\MessageElement;
use Messages\MessageReceiptElement;
use Messages\Address;
use Messages\Summary;
use Messages\Adjustment;



$verify_token = "123"; // Verify token

$token = "EAAXBJEfVHnoBAOD8cMtwn4FdRcmZACcMhtsrZCUhkC9436Ti8bFA2KlZAmnbNmEhI5a8qWktdviY1ojVcOrlxJxg5IAQtR2ybSGaoXFYbZC7RKWoZCpdNtIPJHM8gtbgJm9T4Qm2K5X7qrxxbdH2P18edZAsRhj1SZCIsuKI0VZCUwZDZD";


$bot = new FbBotApp($token);

switch ($data['program']) {
    case "maximum":
        $program = "ТАС Максимум";
        break;
    case "life":
        $program = "ТАС Лайф";
        break;
    default:
        $program = "ТАС максимум";
        break;
}

switch ($data['period']) {
    case "1" :
        $period = "щорічно";
        break;
    case "2" :
        $period = "раз на пів року";
        break;
    case "4" :
        $period = "щоквартально";
        break;
}



$text = "Розрахунок програми $program. Для ";
$text .= $data['gender'] == "m" ? "чоловіка" : "жінки";
$text .= " віком "
    . $data['age'] ." років. Періодичність сплати внесків - " . $period . ". Термін дії договору - " . $data['term'] . " років";

$text = "Загальний внесок - " . round($mainSumm + $secondarySumm) ." UAH.";


$num = [];
$str = [];

foreach ($fares as $key => $val) {
    $num[] = round($val['summ']);
    $str[] = trim($val['tariff']['fares']['description']);

//    $valText = number_format($num, 0, '.', ' ') . " - " . $nm;
//    $bot->send(new Message($id, $valText));
}

$results = formatResult($num, $str);

foreach ($results as $val) {
    $bot->send(new Message($id, $val));
}

if ($secondarySumm > 0) {
    $arr = [
        new MessageElement("Результат обрахунку $program", $text, "", []),

        new MessageElement("Внесок по основним ризикам", round($mainSumm) . " UAH", "", []),

        new MessageElement("Внесок по додатковим ризикам", round($secondarySumm) . " UAH", "", [])
    ];
}
else {
    $arr = [new MessageElement("Результат обрахунку $program", $text, "", [])];
}


$bot->send(new StructuredMessage($id,
    StructuredMessage::TYPE_GENERIC,
    [
        'elements' => $arr
    ]
));



function formatResult($num, $str) {
    $max = 0;
    foreach ($num as $key => $val) {
        $num[$key] = number_format($val, 0, '.', ' ');
        if (strlen($num[$key]) > $max) {
            $max = strlen($num[$key]);
        }
    }
    $result = [];
    foreach ($num as $key => $val) {
        $d = "";
        $a = "";
        $len = strlen($val);
        if ($len < $max) {
            $l = $max - $len;
            $a = "";
            for ($i = 0; $i < $l-1; $i+=2) {
                $a .= "---";
            }
            if (($l%2) == 1) {
                $a .= "-";
            }
        }
        $s = $str[$key];
        $result[] = $a.$val . " - " .$s ;
    }
    return $result;
}