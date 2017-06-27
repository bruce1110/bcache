<?php

require('start.php');
use \Pux\Executor;

$uri = $_SERVER['REQUEST_URI'];
$pattern = '/^\/(.*?)\/(.*?)\/?$/';
$num = preg_match($pattern, $uri, $match);
if($num > 0)
{
	$mux = new Pux\Mux;
	$_con = $match[1];
	$action = $match[2];
	$con = "BCache\App\Controller\\" . $_con . "Controller";
	$controller = new $con();
	$submux = $controller->expand();
	$mux->mount( '/users' , $submux);
	$a = $mux->dispatch('/users/'. $action);
	if(!empty($a))
		Executor::execute($a);
}
/* $um = new UsersMapper(); */
/* $a = $um->find_one_by_name_and_address_order_by_id_desc(array('address'=>'shanghai', 'name'=>'qin')); */
/* $a->name = 'qinchong'; */
/* $b = $um->save($a); */
/* var_dump($b);exit; */

/* $user = new Users(); */
/* $user->name = 'qin'; */
/* $user->address = 'shanghai'; */

/* $a = $um->save($user); */
/* var_dump($a); */

//http://blog.csdn.net/happen_zhang/article/details/12761747
