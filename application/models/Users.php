<?php
use BCache\App\Mapper\UsersMapper;
use BCache\App\Entity\Users;
use BCache\Libs\Db\My;
class UsersModel
{
	public function __construct()
	{}

	public function add()
	{
		$user = new UsersMapper();
		return $user;
	}
	public function update($name)
	{
		$um  = new UsersMapper();
		$user = $um->find_one_by_name(array('name'=>'qinchong'));
		if(!empty($user))
		{
			$user->name = 'qinchong333';
			return $um->save($user);
		}
	}

	public function insert()
	{
		$um = new UsersMapper();
		$user  = new Users();
		$user->name = 'bruce';
		$user->address = 'beijing';
		return $um->save($user);
	}

	public function runsql()
	{
		$um = new My();
		$sql = 'select * from users';
		return $um->query($sql);
	}
}
