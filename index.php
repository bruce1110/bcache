<?php
define('ROOT', __DIR__);
define('APPLICATION_PATH', dirname(__FILE__));
require_once(ROOT . '/vendor/autoload.php');
$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini" );

$application->bootstrap()->run();
/* use BCache\App\Application\init; */
/* init::start()->run(); */
