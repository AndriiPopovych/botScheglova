<?php

file_put_contents("1.txt", "dasd");

echo 'php.ini: '; 
echo get_cfg_var('cfg_file_path'); 
phpinfo();
curl_init();



?>