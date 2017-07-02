<?php

/*

* TgBot by Fabi (Naoki codename)
* Licence: All rights reserved
* Permisions: Free to use by including credits to the original author (Me, Fabi).

- Config Statics Values in tgbot.php

*/

error_reporting(0);

require_once 'Requests.class.php';
require_once 'tgbot.php';

$input = file_get_contents("php://input");

$botObj = new TgBot($input);




