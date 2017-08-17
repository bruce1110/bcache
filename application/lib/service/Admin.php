<?php

class service_Admin extends service_Base
{
	public function min($a, $b)
	{
		return $a > $b ? $b : $a;
	}
}
