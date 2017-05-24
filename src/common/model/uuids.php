<?php

namespace common\model;

use libs\model\base;

class uuids extends base
{
	protected $id;
	protected $table=array();
	protected $tablename = 'uuids';
	public function __construct($id = 0)
	{
		parent::__construct($id);
	}
}
