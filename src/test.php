<?php

include('start.php');
use libs\db\my;
use common\model\users;

/* $my = new my(); */
/* $my->query('insert into uuids values()'); */
/* var_dump($my->lastInsertId()); */

$u = new users(13);
/* var_dump($u->name); */
/* $u->name = 'qinchong111'; */
/* $u->address = 'sh'; */
$u->name = 'qc';
$u->address = 'tj';
