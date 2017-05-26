<?php

namespace BCache\Libs\UUId;

use BCache\Libs\Db\My;

class IdCreate
{
	public static function get()
	{
		$m = new my();
		$m->query('insert into uuids value()');
		return $m->lastInsertId();
	}
}
