<?php

class service
{
  public function HelloWorld()
   {
      return  "Hello";
   }
  public  function Add($a,$b)
   {
      return $a+$b;
   }
}

class user
{
	public function __construct()
	{

	}
	public function min()
	{
		return 'oo';
	}
	public function max( $a, $b )
	{
		$max = $a > $b ? $a : $b;
		return 'max:' . $max;
	}
}
if($_GET['act'] == 'user')
{
$server=new SoapServer(null,array('uri' => "user"));
$server->setClass('user');
$server->handle();
}
else
{
$server=new SoapServer(null,array('uri' => "abcd"));
$server->setClass("service");
$server->handle();
}
