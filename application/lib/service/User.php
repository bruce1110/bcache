<?php

class service_User extends service_Base
{
	public function __construct()
	{
		$this->classname = __CLASS__;
	}
	public function max($a, $b)
	{
		return $a > $b ? $a : $b;
	}

	public function admin_min($a, $b)
	{
		$adminClient = $this->getClient('service_Admin');
		return $adminClient->min($a,$b);
	}
}
