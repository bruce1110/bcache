<?php
define('ROOT', __DIR__);
define('APPLICATION_PATH', dirname(__FILE__));
$application = new \Yaf\Application( APPLICATION_PATH . "/conf/application.ini" );
$application->bootstrap()->run();
/* use BCache\App\Application\init; */
/* init::start()->run(); */
