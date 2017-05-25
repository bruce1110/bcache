<?php

define('ROOT', __DIR__ . '/..');
include('libs/load/autoload.php');
spl_autoload_register('libs\load\autoload::load');
