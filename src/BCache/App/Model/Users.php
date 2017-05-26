<?php

namespace BCache\App\Model;

use BCache\Libs\Model\ModelBase;

class Users extends ModelBase
{
	protected $id;
	protected $table=array('name','address');
	protected $tablename = 'users';
	public function __construct($id = 0)
	{
		parent::__construct($id);
	}
}
