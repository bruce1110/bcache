<?php

require('start.php');
use BCache\App\Entity\Users;
use BCache\App\Mapper\UsersMapper;

$um = new UsersMapper();
//$um->find_by_name_and_address(array('name'=>'qin','address'=>'text'));
//$um->name = 'qinchng';
$id = 13;
$name = 'qinchong007';
/* $a = $um->find_all_by_id_and_name_order_by_id_desc_and_name_asc(5,'bruce'); */
$a = $um->find_all_by_id(13);
var_dump($a);


//http://blog.csdn.net/happen_zhang/article/details/12761747
