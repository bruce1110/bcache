<?php

require('start.php');
use BCache\App\Entity\Users;
use BCache\App\Mapper\UsersMapper;

$um = new UsersMapper();
$a = $um->find_one_by_name_and_address_order_by_id_desc(array('address'=>'aaaaa', 'name'=>'gouzi'));
$a->name = 'qinchong';
$b = $um->save($a);
var_dump($b);exit;

/* $user = new Users(); */
/* $user->name = 'qin'; */
/* $user->address = 'shanghai'; */

/* $a = $um->save($user); */
/* var_dump($a); */

//http://blog.csdn.net/happen_zhang/article/details/12761747
