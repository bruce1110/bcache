<?php
define('ROOT', __DIR__);
require_once(ROOT . '/vendor/autoload.php');
use BCache\App\Application\init;
init::start()->run();
