<?php
namespace BCache\App\Controller;
use BCache\Libs\Controller\ControllerBase;

class UsersController extends ControllerBase
{
	
	public function __construct()
	{
		parent::__construct();
	}
	public function addAction()
	{
		$this->smarty->assign('title', 'bruce');
		$this->smarty->assign('Name', 'qin');
		$this->smarty->assign('date', date('Y-m-d H:i:s'));
		$this->smarty->display('users.tpl');
	}

	public function delAction()
	{
		echo 'del';
		$this->isok();
	}
	
}
