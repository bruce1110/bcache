<?php

require('start.php');
use BCache\App\Entity\Users;
use BCache\App\Mapper\UsersMapper;

$um = new UsersMapper();
//$um->find_by_name_and_address(array('name'=>'qin','address'=>'text'));
//$um->name = 'qinchng';
$id = 13;
$name = 'bruce';
/* $a = $um->find_all_by_id_and_name_order_by_id_desc_and_name_asc(5,'bruce'); */
$a = $um->find_one_by_name_order_by_id_desc(array('name'=>'bruce'));
var_dump($a->name);


//http://blog.csdn.net/happen_zhang/article/details/12761747
