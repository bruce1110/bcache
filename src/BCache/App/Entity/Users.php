<?php

namespace BCache\App\Entity;

use BCache\Libs\Entity\EntityBase;

class Users extends EntityBase
{
	protected $name;
	protected $address;
	public function __construct($id = 0)
	{
		parent::__construct($id);
	}
}
