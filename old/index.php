<?php

error_reporting(3);

ini_set('precision', 29);
function __autoload($className)
{
    //$className = preg_replace("/pimax\\\\/", "$1", $className);
    include $className . ".php";
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
$token = "EAAXBJEfVHnoBAJlnGjbEhZChsaALlLBIM2OoW5gNw5RiYmzuf2mhjDk3IG9o60CZAjr8tktp14OO2r4eSSCSLTSFQiDIixfuoaompyOqKkZBvYIOfpLYxW9MLEkoKxrjzcaQkTuL42J75yg8WnRNAGfTmLFfGXZCENujD6wEFwZDZD";
$token = "EAADWkR8VvcQBABPs4ZCIk2Qz6dRF6jNwCk6rpm8sMTF5H88ahJ91ns8PSvAG3ZAWODFDyuZCoHcjj2n0RPW95YTrshRCLeaZBevQTK6jhrCUWJ3Dfj1nUJy0VtNq0qZCpbvP5p8XSKCP52VbXDWmZC3HsPbeojPMqZBYKDKYVjDaAZDZD";

$token = "EAAXBJEfVHnoBABIxsO42uhBTQHUv7bKm15bFpmcwwjsgegy4J8F5TndddStuKHRqUZCgC6nNVUVzKzc9a9P6vqpQkhfPyWjaQWTBBNuA7uXE2ZAsnIIyUSVSN1XIU9XUXmFk5uPP1A3v0E2AfNbaTMeFUtkppVK82t5JuBdQZDZD";

$token = "EAADWkR8VvcQBAJyZAvyIIGZArm5awXlCUTJ18fzaAUMsn5jZCtiTqr8YGi6UlqYSsQW1N7EoshAMAYpsbO6m2cwBI8wFA92dZCxu530apXMQ9FVXgpuD7oKuRvH3MhO1YiymNaRHbgcP5Lk1GqKDg4Y5IQzjxZAxrmU1beqdNRwZDZD";
$token = "EAADWkR8VvcQBAEMMViwsZCXW6afeCIhbBQr2CXgseOO80lHHT7NvQ3JltUEuIrr9ZCMR01SsybFrOQGZCSRB9rgbHMG02Jj8FvZAhj03t9GnVxr2BuQ6avkB58auD5EhUoVXE7m1AbL3H0MxsJ1sAiZAVMLkJGqAdEYai31KZCiAZDZD";


//curl -X POST "https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=EAADWkR8VvcQBABPs4ZCIk2Qz6dRF6jNwCk6rpm8sMTF5H88ahJ91ns8PSvAG3ZAWODFDyuZCoHcjj2n0RPW95YTrshRCLeaZBevQTK6jhrCUWJ3Dfj1nUJy0VtNq0qZCpbvP5p8XSKCP52VbXDWmZC3HsPbeojPMqZBYKDKYVjDaAZDZD"

$bot = new FbBotApp($token);


$programList = [
    "maximum" => [
        "maxTerm" => 20,
        "minTerm" => 5,
        "maxAge" => 60,
        "minAge" => 18
    ],
    "life" => [
        "maxTerm" => 20,
        "minTerm" => 10,
        "maxAge" => 65,
        "minAge" => 18
    ],
    "kids" => [
        "maxTerm" => 20,
        "minTerm" => 5,
        "maxAge" => 17,
        "minAge" => 0
    ],
    "junior" => [
        "maxTerm" => 20,
        "minTerm" => 10,
        "maxAge" => 17,
        "minAge" => 0
    ]
];

$commandList = json_decode(file_get_contents("lib/dictionary.json"));


// Receive something
if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == $verify_token) {
// Webhook setup request

    echo $_REQUEST['hub_challenge'];
    //die();
} else {
   // include_once "test.html";
// Other event
    $data = json_decode(file_get_contents("php://input"), true);
    $aaa = file_get_contents("aaa/1.json");
    $aaa = json_decode($aaa, true);
    $aaa[] = $data;
//    file_put_contents("1.txt", json_encode($data));
    if (!empty($data['entry'][0]['messaging'])) {
        foreach ($data['entry'][0]['messaging'] as $message) {
// Skipping delivery messages
            if (!empty($message['delivery'])) {
                //continue;
                die();
            }
            $command = "";
// When bot receive message from user
            if (!empty($message['message'])) {
                /*
    $bot->send(new \Messages\ImageMessage($sender, 'http://risovach.ru/upload/2013/05/mem/volk_18696515_orig_.jpeg'));
        send($sender, "Звертайся))");


                */
                //send($message['sender']['id'], "Ведуться технічні роботи.");
                //$bot->send(new Message($sender, "Ведуться технічні роботи.", [], true));
                //die();
                $command = $message['message']['text'];
// When bot receive button click from user
            } else if (!empty($message['postback'])) {
                file_put_contents("1.txt", "a".json_encode($message['postback']), FILE_APPEND);
                //send($message['sender']['id'], "Ведуться технічні роботи.");
                //die();
                //$bot->send(new Message($sender, "Ведуться технічні роботи.", [], true));
                $arr = explode(".", $message['postback']['payload']);
                if (count($arr) > 1) {
                    $command = $arr[0];
                    $program = $arr[1];
                } else {
                    $command = $message['postback']['payload'];
                }
            }
            else {
                die();
            }
            $sender = $message['sender']['id'];

            //$bot->send(new Message($sender, "here". $command));
            //die();

            $d = file_get_contents("commands.json");
            $d = json_decode($d);
            $d[] = $command;

            //$bot->send(new Message($sender, "here". $command));
            //file_put_contents("aaa/1.json", json_encode($data));
            //die();

            file_put_contents("commands.json", json_encode($d));

            switch ($command) {
// When bot receive "text"
                // case 'test':
                //     saveValue($sender, "test");
                //     $bot->send(new Message($sender, 'Sam test, yopta!'));
                //     break;
                case "calculateProgram":
                    $arr = file_get_contents("lib/email.json");
                    $obj = json_decode($arr, true);
                    $obj[$sender] = false;
                    $str = json_encode($obj);
                    file_put_contents("lib/email.json", $str);
                    $data = new Data();
                    $data->next = "age";
                    saveValue($sender, $data);
                    sendProgramList();
//                    send($sender, 'Оберіть програму, натиснувши на кнопку.', [
//                        ['ТАС Максимум', "program.maximum"],
//                        ['ТАС Лайф', "program.life"]]);
                    break;
                case "program":
                    if ($programList[$program]) {
                        $data = new Data();
                        $data->program = $program;
                        $data->id = $sender;
                        $data->next = "age";
                        $bot->send(new Message($sender, "Введіть вік застрахованого", [], true));
                        saveValue($sender, $data);
                    }
                    else {

                        $arr = file_get_contents("lib/email.json");
                        $obj = json_decode($arr, true);
                        $obj[$sender] = false;
                        $str = json_encode($obj);
                        file_put_contents("lib/email.json", $str);
                    }
                    break;
                // case "aaa":
                //     send($sender, "bebebe");
                //     break;
// Other message received
                default:
                    if ($command == "ти тут?") {
                        send($sender, "тутa");
                        break;
                    }
                    $arr = ["хочу журнал",
                      "журнал", "будущее", "майбутнє", "журнал майбутнє", "журнал будущее", "хочу знать будущее", "хочу знати майбутнє", "дай маркетингу журнал"];

                    $thisIsJournal = false;

                    foreach ($arr as $val) {
                      if (preg_match("/" . $val . "/Uisu", $command)) {
                        $thisIsJournal = true;
                      }
                    }
                    if ($thisIsJournal) {
                        $arr = file_get_contents("lib/email.json");
                        $obj = json_decode($arr, true);
                        if ( $obj[$sender] === false ) {
                                send($sender, "Тримай - http://goo.gl/T9JAIQ.  І пам’ятай - майбутнє вже наступило!");
                                send($sender, "P.S. адже ти зараз розмовляєш з неіснуючим пінгвіном :)");
                        }
                        else {
                            $obj[$sender] = "complete";
                            $str = json_encode($obj);
                            file_put_contents("lib/email.json", $str);
                            send($sender, "давай свою емейл адресу");
                        }
                        
                        break;
                    }
                    else {
                        $arr = file_get_contents("lib/email.json");
                        $obj = json_decode($arr, true);
                        if ($obj[$sender] === "complete") {
                            if (preg_match("/[a-z0-9\.]+@[a-z0-9\.]+/Uisu", $command)) {
                                $obj[$sender] = false;
                                $str = json_encode($obj);
                                file_put_contents("lib/email.json", $str);
                                file_put_contents("lib/emailList.json", $command . "; ", FILE_APPEND);

                                send($sender, "Тримай - http://goo.gl/T9JAIQ.  І пам’ятай - майбутнє вже наступило!");
                                send($sender, "P.S. адже ти зараз розмовляєш з неіснуючим пінгвіном :)");
                                break;
                            }
                            else {

                                send($sender, "А от обманювати мене не потрібно.. Мені потрібна справжня емейл адреса!");
                                break;
                            }

                        }
                    }

                    // if ($command == "asd") {
                    //     $bot->send(new \Messages\ImageMessage($sender, 'http://risovach.ru/upload/2013/05/mem/volk_18696515_orig_.jpeg'));
                    //     break;
                    // }
                    if (!checkCommand($command)) {

                        if (file_exists("db/" . $sender . ".json")) {
                            $data = json_decode(file_get_contents("db/" . $sender . ".json"));
                            if ($data) {
                                if (!$data->program) {

                                    send($sender, "Оберіть програму натиснувши на кнопку.");
                                    die();
                                }
                                if ($data->time > 0) {
                                    if ((time() - $data->time) > 60*15) {
                                        saveValue($sender, "");
                                        send($sender, "Ваш час вичерпано" );//. time() . " -- ". $data->time . " === ". (time() - $data->time));
                                        help();
                                        die();
                                    }
                                }
                                else {
                                    $data->time = time();
                                }

                                if ($data->next == 'age') {
                                    $command = (int)$command;
                                    if ($command >= $programList[$data->program]['minAge']
                                        && $command <= $programList[$data->program]['maxAge']
                                    ) {
                                        $data->age = $command;
                                        $data->next = 'gender';
                                        saveValue($sender, $data);
                                        // if ($data->program == "junior" || $data->program == "kids") {

                                        // }
                                        // else {
                                            send($sender, "Оберіть стать застрахованого", [
                                            ["Чоловік", "m"],
                                            ["Жінка", "f"],
                                        ], true);
                                        // }

                                    } else {
                                        send($sender, "Mінмальний вік- " . $programList[$data->program]['minAge'] . " років.
Mаксимальний вік- " . $programList[$data->program]['maxAge'] . " років.
Введіть коректні дані.");
                                    }
                                }
                                elseif ($data->next == 'gender') {

                                    $data->date = time();
                                    if ($command == "m" || $command == "f") {
                                        $data->gender = $command;
                                        if ($data->program == "kids" || $data->program == "junior") {
                                            $data->next = "ageInsurer";
                                            saveValue($sender, $data);
                                            sendCommand("ageInsurer");
                                        }
                                        else {
                                            $data->next = "insurerIsInsured";
                                            $data->next = "term";
                                            saveValue($sender, $data);
                                            sendCommand("term");
                                        }



//                                        send($sender, "Введіть термін дії договору",[], true);
                                    } else {
                                        send($sender, "Оберіть стать натиснувши на кнопку");
                                    }
                                }
                                elseif ($data->next == "ageInsurer") {
                                    $command = (int) $command;
                                    if ($command >= 18 && $command <= 65) {
                                        $data->ageInsurer = $command;
                                        $data->next = "genderInsurer";
                                        saveValue($sender, $data);
                                        sendCommand("genderInsurer");
                                    }
                                    else {
                                        send($sender, "Mінмальний вік- " . 18 . " років.
Mаксимальний вік- " . 65 . " років.
Введіть коректні дані.");
                                    }
                                }
                                elseif ($data->next == "genderInsurer") {
                                    if ($command == "m" || $command == "f") {
                                        $data->genderInsurer = $command;
                                        $data->next = "term";
                                        saveValue($sender, $data);
                                        sendCommand("term");
                                    }
                                    else {
                                        send($sender, "Оберіть стать натиснувши на кнопку");
                                    }
                                }
                                elseif ($data->next == "insurerIsInsured") {
                                    if ($command == "true") {
                                        $data->insurerIsInsured = true;
                                        $data->next = "ageInsurer";
                                        sendCommand("age");
                                    }
                                    else {
                                        $data->insurerIsInsured = false;
                                        $data->next = "term";
                                        sendCommand("term");
                                    }
                                    saveValue($sender, $data);
                                }



                                elseif ($data->next == 'term') {
                                    $data->date = time();
                                    $command = (int)$command;
                                    if ($command >= $programList[$data->program]['minTerm']
                                        && $command <= $programList[$data->program]['maxTerm']
                                    ) {
                                        $data->term = $command;
                                        $data->next = "period";
                                        saveValue($sender, $data);
                                        sendCommand("period");
                                    } else {
                                        //Термін дії договору повинен бути від 5 до 20 років
                                        //send($sender, "мінмальний термін договору- " . $programList[$data->program]['minTerm'] . " років.
//максимальній термін договору- " . $programList[$data->program]['maxTerm'] . " років.
//Введіть коректні дані. ");
                                        send($sender, "Термін дії договору повинен бути від  " . $programList[$data->program]['minTerm'] . " до
" . $programList[$data->program]['maxTerm'] . " років.");
                                    }
                                }
                                elseif ($data->next == 'period') {
                                    $data->date = time();
                                    $command = (int)$command;
                                    if ($command == 1 || $command == 2 || $command == 4) {
                                        $data->period = (int)$command;
                                        $data->next = "calculateFrom";
                                        saveValue($sender, $data);
                                        sendCommand("calculateFrom");//, true);
//send($sender, "Введіть страхову суму");
                                    } else {
                                        send($sender, "Оберіть періодичність натиснувши на кнопку.");
                                    }
                                }
                                elseif ($data->next == "calculateFrom") {
                                    $data->date = time();
                                    if ($command == "summ") {
                                        $data->type = 1;
                                        $data->next = "calculate";
                                        sendCommand("summ");
//                                        send($sender, "Введіть страхову сумму по дожиттю.", [], true);
                                        saveValue($sender, $data);
                                    }
                                    elseif ($command == "contr") {

                                        $data->type = 2;
                                        $data->next = "risksSet";
                                        sendCommand("risksSet");
//                                        send($sender, "Оберіть ризики", [
//                                            ["Основні страхові випадки", "mainRisks"],
//                                            ["Основні та додаткові страхові випадки", "allRisks"]
//                                        ], true);
                                        saveValue($sender, $data);
                                    }
                                    else {
                                        send($sender, "Оберіть метод розрахунку, натиснувши на кнопку.");
                                    }
                                }
                                elseif ($data->next == "risksSet") {
                                    $data->main = $command == "mainRisks" ? 1 : 0;
                                    $data->next = "calculate";
                                    sendCommand("contribution");
//                                    send($sender, "Введіть внесок.", [], true);
                                    saveValue($sender, $data);
                                }
                                elseif ($data->next == "calculate") {

                                    if ($data->type == 2 && $data->main !== 1 && $data->main !== 0) {
                                        send($sender, "Оберіть ризики, натиснувши на кнопку.");
                                        break;
                                    }

                                    $command = preg_replace("/\s+/", "", $command);
                                    $data->summ = (int)$command;
                                    $result = file_put_contents("db/db.json", "http://localhost:3333/api/calculate?data=" . json_encode($data));
                                    $resultCalc = file_get_contents("http://localhost:3333/api/calculate?data=" . json_encode($data));

                                    $resultCalc = json_decode($resultCalc, true);
                                    calculate($resultCalc, $data);
                                    $result = file_get_contents("db/db.json");
                                    $result = json_decode($result, true);
                                    $result[] = $data;
                                    file_put_contents("db/" . $sender . ".json", "");
                                    saveValue("db", $result);
                                }
                                else {
                                    $data->date = time();
                                    undefinedCommand($sender);
                                }
                            } else {
                                $data->date = time();
                                undefinedCommand($sender);
                            }
                        } else {
                            //$data->date = time();
                            undefinedCommand($sender);
                        }
                    }
                    else {
                        undefinedCommand($sender);
                    }
                // die();
            }
        }
    }
}

function saveValue($sender, $value)
{
    $fileName = "db/" . $sender . ".json";
//if (!file_exists($fileName)) {
    $fp = fopen($fileName, 'w');
    fwrite($fp, json_encode($value));
    fclose($fp);
    chmod($fileName, 0777);
//}
}

function send($id, $text, $buttons = [], $back = false)
{
    global $bot;
    $buttonArr = [];
    if ($buttons) {
        foreach ($buttons as $button) {
            $buttonArr[] = new MessageButton(MessageButton::TYPE_POSTBACK, $button[0], $button[1]);
        }
        if ($back) {
            //if (count($buttonArr) > 2) {
            if (true) {
                $sendBack = true;
                //sendBack();
            }
            else {
                $buttonArr[] = new MessageButton(MessageButton::TYPE_POSTBACK, "Крок назад", "_back");
            }
        }
        if ($sendBack) {
            sendBack();
        }
        $bot->send(new StructuredMessage($id,
            StructuredMessage::TYPE_BUTTON,
            [
                'text' => $text,
                'buttons' => $buttonArr
            ]
        ));
    } else {
        if ($back) {
            //$buttonArr[] = new MessageButton(MessageButton::TYPE_POSTBACK, "Крок назад", "_back");
            // $bot->send(new StructuredMessage($id,
            //     StructuredMessage::TYPE_BUTTON,
            //     [
            //         'text' => $text
            //         ,
            //         'buttons' => $buttonArr
            //     ]
            // ));
            sendBack();
            $bot->send(new Message($id, $text));
        }
        else {
            $bot->send(new Message($id, $text));
        }
    }
}

function checkCommand($command)
{
    //global $commandList;

    $commandList = [
        "help"=> [
            "помощь",
            "помощ",
            "помочь",
            "помоч",
            "допоможи",
            "допомога",
            "допомогти",
            "умеешь",
            "умееш",
            "вмієшь",
            "вмієш",
            "команди",
            "команда",
            "команды",
            "помоги",
            "що вмієш?",
            "help"
        ],
        "hello"=> [
            "здравствуйте",
            "здравствуй",
            "добрый день",
            "привет",
            "здаров",
            "прв",
            "доброго дня",
            "привіт",
            "hi",
            "hello"
        ],
        "thanks" => [
            "дякую!",
            "круто, дякую",
            "круто, дякую!",
            "дякую",
            "спасибо",
            "спасибо!",
            "класс!",
            "класс", 
            "thanks",
            "thank"
        ],
        "_back" => [
            "назад",
            "відміна",
            "отмена",
            "отменить",
            "охрана отмена",
            "бля",
            "_back"
        ],
        "sendProgramList" => [
            "розрахуй",
            "розрахунок",
            "посчитай",
            "посчитать",
            "рассчет",
            "рассчитай",
            "рассчитать",
            "расчет",
            "расчитай",
            "расчитать",
            "розрахунок програми",
            "розрахунок програми страхування",
            "рассчет программы",
            "рассчет программы страхования"
        ]
    ];

    global $sender;
    $command = mb_strtolower($command);


    // $commandList1 = file_get_contents("lib/dictionary.json");//json_decode(file_get_contents("lib/dictionary.json"), true);
    //file_put_contents("1.txt", json_encode($commandList));
    // file_put_contents("1.txt", file_get_contents("lib/dictionary.json"));
    //send($sender,json_encode($commandList['help']));

            // send($sender,  $command);
    foreach ($commandList as $key => $_val) {
        //if (in_array($command, $val)) {
        foreach ($_val as $val) {
            if (preg_match("/" . $val . "/Uisu", $command)) {
            //if (in_array($command, $val)) {
                if (function_exists($key)) {
                //send($sender,"111");
                    $key();

                    die();
                    // return $key();
                    return true;
                } else {

                }
            }
        }
        
    }
    return false;
}

function hello()
{
    global $sender;
    send($sender, "І тобі привіт!");
    return true;
}

function help()
{
    global $sender;
    send($sender, 'Чим я вам можу допомогти?', [
        ['Розрахувати страховку', "calculateProgram"], ["Почитати журнал", "хочу журнал"]]);
    return true;
}

function undefinedCommand($sender)
{
//     $data = json_decode(file_get_contents("php://input"), true);
//     file_put_contents("1.txt", json_encode($data));
//     if (!empty($data['entry'][0]['messaging'])) {
//         foreach ($data['entry'][0]['messaging'] as $message) {
// // Skipping delivery messages
//             if (!empty($message['delivery'])) {
//                 //continue;
//                 die();
//             }
//         }
//     }
    //send($sender, 'Я вас не розумію. Оберіть команду, натиснувши на кнопку', [
     //   ['Розрахувати страховку', "calculateProgram"], ["Почитати журнал", "хочу журнал"]]);
    send($sender, 'Поки що я вмію тільки рахувати та розповсюджувати класний журнал про страхування. Якщо залишились питання - дзвони в контакт-центр СК 0 800 500 117.', [
        ['Розрахувати страховку', "calculateProgram"], ["Почитати журнал", "хочу журнал"]]);
    return true;
}

function sendProgramList()
{
    global $bot;
    global $sender;
        $arr = [
            new MessageElement("Оберіть програму, натиснувши на кнопку.", "", "", [
                new MessageButton(MessageButton::TYPE_POSTBACK, "ТАС Максимум", "program.maximum")
                ,
                new MessageButton(MessageButton::TYPE_POSTBACK, "ТАС Лайф", "program.life")
            ]),

            new MessageElement("Оберіть програму, натиснувши на кнопку.", "", "", [
                new MessageButton(MessageButton::TYPE_POSTBACK, "ТАС Кідс", "program.kids"),
                new MessageButton(MessageButton::TYPE_POSTBACK, "ТАС Юніор", "program.junior")
            ]),

        ];


    $bot->send(new StructuredMessage($sender,
        StructuredMessage::TYPE_GENERIC,
        [
            'elements' => $arr
        ]
    ));



//    send($sender, 'Оберіть програму, натиснувши на кнопку.', [
//        ['ТАС Максимум', "program.maximum"],
//        ['ТАС Лайф', "program.life"]]);
    return true;
}

function calculate($results, $obj)
{
    global $sender;
    global $bot;
    file_put_contents("1.txt", json_encode($results));
    $id = $results["a"];
    $fares = $results["b"];
    $mainSumm = $results["c"];
    $secondarySumm = $results["d"];
    /**
     * @var Data
     */
    $data = $results["e"];

    $id = $data['id'];
    switch ($data['program']) {
        case "maximum":
            $program = "ТАС Максимум";
            break;
        case "life":
            $program = "ТАС Лайф";
            break;
        case "kids":
            $program = "ТАС Кідс";
            break;
        case "junior":
            $program = "ТАС Юніор";
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
        . $data['age'] . " років. Періодичність сплати внесків - " . $period . ". Термін дії договору - " . $data['term'] . " років. Страхові суми по ризикам:";

    $bot->send(new Message($id, $text));
    $text = "Загальний внесок - " . round($mainSumm + $secondarySumm) . " UAH.";


    $num = [];
    $str = [];
    $s = 0;
    $term = 1;
    $period = 1;
    foreach ($fares as $key => $val) {
        if ($val['check'] == 1 && $val['visibility'] == 1 && $val['check'] == 1 && $key != "wop_1" && $key != "wop_2") {
            $s += $val['summ'];
        }
        elseif ($val['check'] == 1 && $val['check'] == 1 && ($key == "wop" || $key == "wop_1" || $key == "wop_2")) {
            $term = $val['term'];
            $period = $val['tariff']['period'];
        }
    }
    $s = $s * $term*$period;
    foreach ($fares as $key => $val) {
        if ($data->main != 1) {
            $num[] = round($val['summ']);
            //$num[] = $val['tariff']['value'];
            $str[] = trim($val['tariff']['fares']['description']);
        }
        else {
            if ($val['main']) {
                $num[] = round($val['summ']);
                //$num[] = $val['tariff']['value'];
                $str[] = trim($val['tariff']['fares']['description']);
            }
        }


//    $valText = number_format($num, 0, '.', ' ') . " - " . $nm;
//    $bot->send(new Message($id, $valText));
    }

    $results = formatResult($num, $str);

    foreach ($results as $val) {
        $bot->send(new Message($id, $val));
    }

    if ($secondarySumm > 0) {

        $bot->send(new Message($id, $text));
        $bot->send(new Message($id, "Внесок по основним ризикам - " . round($mainSumm) . " UAH"));
        $bot->send(new Message($id, "Внесок по додатковим ризикам - " . round($secondarySumm) . " UAH"));
        // $bot->send(new Message($id, $text));
        // $arr = [
        //     new MessageElement("Результат обрахунку $program", $text, "", []),

        //     new MessageElement("Внесок по основним ризикам", round($mainSumm) . " UAH", "", []),

        //     new MessageElement("Внесок по додатковим ризикам", round($secondarySumm) . " UAH", "", [])
        // ];
    } else {
        $bot->send(new Message($id, $text));
        $arr = [new MessageElement("Результат обрахунку $program", $text, "", [])];
    }


    /*$bot->send(new StructuredMessage($id,
        StructuredMessage::TYPE_GENERIC,
        [
            'elements' => $arr
        ]
    ));*/
    return true;

}

function formatResult($num, $str)
{
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
            for ($i = 0; $i < $l - 1; $i += 2) {
                $a .= "---";
            }
            if (($l % 2) == 1) {
                $a .= "--";
            }
        }
        $s = $str[$key];
        $result[] = $a . $val . " - " . $s;
    }
    return $result;
}

function thanks()
{
    global $sender;
    global $bot;
//    send($sender, "Звертайся))");

    $bot->send(new \Messages\ImageMessage($sender, 'http://risovach.ru/upload/2013/05/mem/volk_18696515_orig_.jpeg'));
    return true;
//break;
}

function sendBack() {
    global $sender;

                //$buttonArr[] = new MessageButton(MessageButton::TYPE_POSTBACK, "Крок назад", "_back");
    send($sender, "Помилка?", [
        ["Крок назад", "_back"]
    ]);
    return true;
}

function _back() {
    global $sender;
    if (file_exists("db/" . $sender . ".json")) {
        $data = json_decode(file_get_contents("db/" . $sender . ".json"));
        if ($data) {
            if (!$data->age) {
                $data->program = null;
                sendProgramList();
            }
            elseif (!$data->gender) {
                $data->age = null;
                sendCommand("age");
                $data->next = "age";
            }
            elseif (!$data->term) {
                $data->gender = null;
                $data->next = 'gender';
                sendCommand("gender");
            }
            elseif (!$data->period) {
                $data->term = null;
                $data->next = "term";
                sendCommand("term");
            }
            elseif ($data->next == "risksSet") {
                $data->summ = null;
                $data->next = "calculateFrom";
                sendCommand("calculateFrom");
            }
            elseif (!$data->type) {
                $data->summ = null;
                $data->next = "period";
                sendCommand("period");
            }
            elseif (!$data->summ) {
                if ($data->type == 1) {
                        $data->summ = null;
                        $data->next = "calculateFrom";
                        sendCommand("calculateFrom");
                }
                else {
                        $data->main = null;
                        // $data->type = null;
                        $data->next = "risksSet";
                        sendCommand("risksSet");
                }
                // $data->period = null;
                // // $data->type = null;
                // $data->next = "period";
                // sendCommand("period");
            }
            saveValue($sender, $data);
            die();
        }
    }
    return true;
}

function sendCommand($what) {
    global $data;
    global $sender;
    switch ($what) {
        case "age":
            send($sender, "Введіть вік застрахованого", [] , true);
            break;
        case "gender":
            send($sender, "Оберіть стать застрахованого", [
                ["Чоловік", "m"],
                ["Жінка", "f"],
            ], true);
            break;
        case "ageInsurer":
            send($sender, "Введіть вік страхувальника ", [] , true);
            break;
        case "genderInsurer":
            send($sender, "Оберіть стать страхувальника", [
                ["Чоловік", "m"],
                ["Жінка", "f"],
            ], true);
            break;
        case "term":
            send($sender, "Введіть термін дії договору", [], true);
            break;
        case "period":
            send($sender, "Оберіть періодичність", [
                ["Щорічно", 1],
                ["Раз у пів року", 2],
                ["Щоквартально", 4]
            ], true);
            break;
        case "summ":
//            $data->next = "calculate";
            send($sender, "Введіть страхову сумму по дожиттю.", [], true);
            break;
        case "risksSet":
//            $data->next = "risksSet";
            send($sender, "Оберіть ризики", [
                ["Основні страхові випадки", "mainRisks"],
                ["Основні та додаткові страхові випадки", "allRisks"]
            ], true);
            break;
        case "contribution":
//            $data->next = "calculate";
            send($sender, "Введіть внесок.", [], true);
            break;
        case "calculateFrom":
            send($sender, "Оберіть метод розрахунку", [
                ["Від страхової сумми", "summ"]
                ,
                ["Від страхового внеску", "contr"]
            ], true);
            break;
    }
}

class Data
{

    public $program;

    public $age;

    public $term;

    public $period;

    public $gender;

    public $summ;

    public $id;

    public $type;

    public $main;

    public $date;

    public $next;

    public $insurerIsInsured;

    public $genderInsurer;

    public $ageInsurer;
}
