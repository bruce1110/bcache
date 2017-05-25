<?php

namespace common\model;

use libs\model\base;

class users extends base
{
	protected $id;
	protected $table=array('name','address');
	protected $tablename = 'users';
	public function __construct($id = 0)
	{
		parent::__construct($id);
	}
}
