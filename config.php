<?php

error_reporting(3);
ini_set('precision', 29);
function __autoload($className)
{
    include $className . ".php";
}

define ("TOKEN", "");
define ("VERIFY_TOKEN", "");
