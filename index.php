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
            send($sender, "Your link (digest)");
            break;
        case "capital" :
            send($sender, "Your link (magazine capital)");
            break;
        case "futureFinance" :
            send($sender, "Your link (magazine future finance)");
            break;
        case "sendRedactor" :
            send($sender, "go to Kate");
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
