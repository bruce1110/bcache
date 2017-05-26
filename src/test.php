<?php

define('ROOT', __DIR__ . '/..');
require('../vendor/autoload.php');

use BCache\App\Model\Users;

$u = new Users(13);
$u->name = 'bruce';
echo $u->address;
