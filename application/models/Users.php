<?php
use BCache\App\Mapper\UsersMapper;
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
}
