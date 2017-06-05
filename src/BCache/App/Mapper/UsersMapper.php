<?php

namespace BCache\App\Mapper;

use BCache\Libs\Mapper\MapperBase;

class UsersMapper extends MapperBase
{
	public $table = 'users';
	public function __construct()
	{
		parent::__construct();
	}
}
