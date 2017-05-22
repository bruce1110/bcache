<?php

include('configs/config.php');
include('cached/mcached.php');

use cached\mcached;
use configs\config;

$m = new mcached();

echo $m->set('name','qinchong');
