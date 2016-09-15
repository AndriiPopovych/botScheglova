<?php


error_reporting(3);
ini_set('precision', 29);
function __autoload($className)
{
    $className = preg_replace("/\\\\/", "/", $className);
    if (file_exists($className . ".php")) {
        include $className . ".php";
    }
    else if (file_exists("Messages/" . $className . ".php")) {
        include "Messages/" .$className . ".php";
    }
    else {
    }
}

define ("TOKEN", "EAAY0vpthk7cBAHGNhFuJTSVTSJVEVLRnIZAOZBzYAFdUboZAhjuBzEE3UtsM9J3pdGZANVbzwJtyP5UWx9MF7IjZB8TPnbyRmiEacqLbcr0ZCxMdYWAZBgJPhMfR0lHyjBmmrv9CSgHHaMP7KVzvaGMJOpGGDGsUWqfndq1XkcrZBQZDZD");
define ("VERIFY_TOKEN", "123");
