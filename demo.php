<?php

require_once 'classes/PreTTYDemo.php';

$demo = new PreTTYDemo;
$demo->addHooker(new PreTTYTierCache);
$demo->run();
