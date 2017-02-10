<?php

require "config.php";


use Messages\Message;
use Messages\MessageButton;
use Messages\StructuredMessage;
use Messages\MessageElement;
use Messages\MessageReceiptElement;
use Messages\Address;
use Messages\Summary;
use Messages\Adjustment;



$bot = new FbBotApp(TOKEN);

require "functions.php";

if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == VERIFY_TOKEN) {
    // Webhook setup request
    echo $_REQUEST['hub_challenge'];
    die();
} else {
    $data = json_decode(file_get_contents("php://input"), true);

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
              $command = $message['message']['text'];
            // When bot receive button click from user
          } else if (!empty($message['postback'])) {
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
          checkCommand($command);
      }
    }
}


function checkCommand($command) {
    global $bot;
    global $sender;

    switch ($command) {
        case "getMagazine" :
            // send($sender, "Раджу почитати два номера на вибір ", [
            //     ["Репутаційний капітал ринку", "capital"],
            //     ["Майбутнє фінансів", "futureFinance"]
            // ]);
            $bot->send(new StructuredMessage($sender,
                StructuredMessage::TYPE_GENERIC,
                [
                    'elements' => [


			new MessageElement("Цифрова економіка та фінтех","Цифрова трансформація в Україні та світі", "http://botscheglova.tasoft.io/files/0.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "http://botscheglova.tasoft.io/files/Future_spreads-Dec%202016.pdf")
                        ]),
			new MessageElement("#3-4 Листопад/ грудень","Найголовніші новини в Україні та світі", "http://botscheglova.tasoft.io/files/digest123.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/XyBkav")
                        ]),
			new MessageElement("Фінтех в Україні", "Мапа ринку та ключові гравці і тренди", "http://botscheglova.tasoft.io/files/new.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/fMBuwT")
                        ]),
                       
			new MessageElement("#2 Вересень/ Жовтень","Найголовніші новини в Україні та світі", "http://botscheglova.tasoft.io/files/baner.jpg", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/bHNsnb")
                        ]),
                        new MessageElement("Майбутнє фінансів у світі", "Глобальні фінтех-тренди", "http://botscheglova.tasoft.io/files/Fintech-magazine.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/KJ0ePA")
                        ]),
                        new MessageElement("#1 Серпень/Вересень", "Найголовніші новини в Україні та світі", "http://botscheglova.tasoft.io/files/baner1.jpg", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/BWPf7j")
                        ]),
                        new MessageElement("Екосистема фінтеху в Україні", "Мапа ринку", "http://botscheglova.tasoft.io/files/ecomaps.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/uNMikV")
                        ])
                        /*new MessageElement("Репутаційний капітал ринку", "Чому його важливо створювати", "http://botscheglova.tasoft.io/files/maybutne.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/T4OObv")
                        ]),*/
                        
                    ]
                ]
            ));
            break;	
	case "getPresentation" :
            $bot->send(new StructuredMessage($sender,
                StructuredMessage::TYPE_GENERIC,
                [
                    'elements' => [
                        new MessageElement("ТОП-5 принципів", "Трансформації фінансового сектору", "http://botscheglova.tasoft.io/files/top5.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/ayuA2H")
                        ]),
                        new MessageElement("ТОП-10 іншуртех-трендів", "Ключові тренди галузі на 2017 рік", "http://botscheglova.tasoft.io/files/top10.png", [
                            new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/xk685u")
                        ])
                    ]
                ]
            ));
            break;
        /*case "getDigest" :
            // send($sender, "Раджу почитати два ", [
            //     ["Репутаційний капітал ринку", "capital"],
            //     ["Майбутнє фінансів", "futureFinance"]
            // ]);
            $bot->send(new StructuredMessage($sender,
                StructuredMessage::TYPE_GENERIC,
                [
                    'elements' => [
                        
                    ]
                ]
            ));
            break;*/
        case "getFintech" :
            send($sender, "Дякую за вибір, тримай!
Сподіваюсь, тобі буде цікаво)
https://goo.gl/BWPf7j");
            break;
        case "capital" :
            send($sender, "Your link (magazine capital)");
            break;
        case "futureFinance" :
            send($sender, "Дякую за вибір, тримай!
Сподіваюсь, тобі буде цікаво)
https://goo.gl/KJ0ePA");
            break;
        case "sendRedactor" :
            send($sender, "Дякую за вибір! http://m.me/catherine.shcheglova");
            break;
        case "test":
            hello();
            break;
        case "endYes":
            sendMenu($bot, $sender);
            break;
        case "endNo":
		send($sender, "Дякуємо, що звернулись)");
            break;
        default:
$command = mb_strtolower($command);
            if (preg_match("/спасибо/Uisu", $command) || preg_match("/дякую/Uisu", $command)) {
              send($sender, "Чи можу я ще чимось допомогти?", [
                 ["Так", "endYes"],
                 ["Ні", "endNo"]
             ]);
              //send($sender, "будь ласка)");
              break;
            }
            hello();
            // send($sender, "Привіт, мене звати Джен! Обери, що тебе цікавить", [
            //     ["Свіжий номер журналу ", "getMagazine"],
            //     ["Фінтех-дайджест", "getFintech"],
            //     ["Запитання редактору", "sendRedactor"]
            // ]);
            break;
    }

}

function hello() {
    global $sender;
    global $bot;
    send($sender, "Привіт, мене звати Джен! Обери, що тебе цікавить");
    // $bot->send(new StructuredMessage($sender,
    //     StructuredMessage::TYPE_GENERIC,
    //     [
    //         'elements' => [
    //             new MessageElement("Свіжий номер журналу", "Маєш декілька номерів на вибір", "http://botscheglova.tasoft.io/files/magazine.jpg", [
    //                 new MessageButton(MessageButton::TYPE_POSTBACK, 'Обрати номер', "getMagazine")
    //             ]),

    //             new MessageElement("Фінтех-дайджест", "Новини в Україні та світі", "http://botscheglova.tasoft.io/files/digest_3.png", [
    //                 //new MessageButton(MessageButton::TYPE_WEB, 'Переглянути', "https://goo.gl/BWPf7j")
			//new MessageButton(MessageButton::TYPE_POSTBACK, 'Обрати номер', "getDigest")
    //             ]),

    //             new MessageElement("Запитання редактору", "В чаті з головним редактором ви зможете задати будь яке запитання", "http://botscheglova.tasoft.io/files/Brand.png", [
    //                 new MessageButton(MessageButton::TYPE_WEB, "Зв’язатися ", "http://m.me/catherine.shcheglova"),
    //             ])
    //         ]
    //     ]
    // ));
    sendMenu($bot, $sender);
}

function sendMenu($bot, $sender) {
	$bot->send(new StructuredMessage($sender,
        StructuredMessage::TYPE_GENERIC,
        [
            'elements' => [
                new MessageElement("Official Future bot ", "", "http://botscheglova.tasoft.io/files/Brand.png", [
                    new MessageButton(MessageButton::TYPE_POSTBACK, 'Свіжий журнал / дайджест', "getMagazine"),
                    new MessageButton(MessageButton::TYPE_POSTBACK, 'Презентації', "getPresentation"),
                   // new MessageButton(MessageButton::TYPE_WEB, 'Фінтех-дайджест', "https://goo.gl/BWPf7j"),
                    new MessageButton(MessageButton::TYPE_WEB, 'Запитання редактору', "http://m.me/catherine.shcheglova")
                ])
            ]
        ]
    ));
}

function get() {
    global $sender;
    $curl = curl_init();

    $header = [
    ];
    $header[] = "Content-Type: application/json";
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=' . TOKEN,
        CURLOPT_POST => 1
        ));
    $header = [
    ];
    $header[] = "Content-Type: application/json";
    $dataJSON = '{
  "recipient":{
    "id":"'.$sender.'"
  },
  "message":{
    "attachment":{
      "type":"file",
      "payload":{
        "url":"https://botscheglova.tasoft.io/files/Fintech-digest.pdf"
      }
    }
  }
}';
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query(json_decode($dataJSON)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    $response = curl_getinfo($curl);

    // Close request to clear up some resources
    curl_close($curl);

}
