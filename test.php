<?php

require('start.php');
use BCache\App\Model\Users;

$u = new Users(13);
echo $u->name;
