<?php


use Messages\Message;
use Messages\MessageButton;
use Messages\StructuredMessage;
use Messages\MessageElement;
use Messages\MessageReceiptElement;
use Messages\Address;
use Messages\Summary;
use Messages\Adjustment;

function send($id, $text, $buttons = [])
{
    global $bot;
    $buttonArr = [];
    if ($buttons) {
        foreach ($buttons as $button) {
            $buttonArr[] = new MessageButton(MessageButton::TYPE_POSTBACK, $button[0], $button[1]);
        }
        $bot->send(new StructuredMessage($id,
            StructuredMessage::TYPE_BUTTON,
            [
                'text' => $text,
                'buttons' => $buttonArr
            ]
        ));
    } else {
        $bot->send(new Message($id, $text));
    }
}
