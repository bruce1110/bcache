<?php

namespace libs\load;

class autoload
{
	public static function load($name)
	{
		include_once(ROOT . '/src/' . str_replace('\\', '/', $name) . '.php');
	}
}
