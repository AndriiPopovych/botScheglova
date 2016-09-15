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
            send($sender, "Раджу почитати два номера на вибір ", [
                ["Репутаційний капітал ринку", "capital"],
                ["Майбутнє фінансів", "futureFinance"]
            ]);
            break;
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
            send($sender, "Привіт, мене звати Джен! Обери, що тебе цікавить");
            $bot->send(new StructuredMessage($message['sender']['id'],
                StructuredMessage::TYPE_GENERIC,
                [
                    'elements' => [
                        new MessageElement("Свіжий номер журналу", "Just read this", "", [
                            new MessageButton(MessageButton::TYPE_POSTBACK, 'Прочитати')
                        ]),

                        new MessageElement("Фінтех-дайджест", "Read!!!", "", [
                            new MessageButton(MessageButton::TYPE_POSTBACK, 'First button'),
                            new MessageButton(MessageButton::TYPE_POSTBACK, 'Second button')
                        ]),

                        new MessageElement("Запитання редактору", "Напиши редактор", "", [
                            new MessageButton(MessageButton::TYPE_POSTBACK, 'First button'),
                            new MessageButton(MessageButton::TYPE_POSTBACK, 'Second button')
                        ])
                    ]
                ]
            ));
            break;
        default:
            send($sender, "Привіт, мене звати Джен! Обери, що тебе цікавить", [
                ["Свіжий номер журналу ", "getMagazine"],
                ["Фінтех-дайджест", "getFintech"],
                ["Запитання редактору", "sendRedactor"]
            ]);
            break;
    }

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
