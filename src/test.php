<?php

include('start.php');
use db\My;


$my = new My();
$a = $my->query('select * from uids');
var_dump($a);
