<?php

error_reporting(3);
ini_set('precision', 29);
function __autoload($className)
{
    include $className . ".php";
}

define ("TOKEN", "EAAY0vpthk7cBAHGNhFuJTSVTSJVEVLRnIZAOZBzYAFdUboZAhjuBzEE3UtsM9J3pdGZANVbzwJtyP5UWx9MF7IjZB8TPnbyRmiEacqLbcr0ZCxMdYWAZBgJPhMfR0lHyjBmmrv9CSgHHaMP7KVzvaGMJOpGGDGsUWqfndq1XkcrZBQZDZD");
define ("VERIFY_TOKEN", "123");
