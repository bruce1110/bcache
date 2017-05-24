<?php

include('start.php');
use libs\db\my;


$my = new my();
$my->query('insert into uids values()');
var_dump($my->lastInsertId());
