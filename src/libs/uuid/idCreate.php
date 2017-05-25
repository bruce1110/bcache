<?php

namespace libs\uuid;

use libs\db\my;

class idCreate
{
	public static function get()
	{
		$m = new my();
		$m->query('insert into uuids value()');
		return $m->lastInsertId();
	}
}
