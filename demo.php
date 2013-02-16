<?php

require_once 'classes/PreTTYDemo.php';

$demo = new PreTTYDemo(new PreTTYColorEncoder, array(new PreTTYProgressBar, new PreTTYTierCache, new PreTTYFormatter));
$demo->run();
