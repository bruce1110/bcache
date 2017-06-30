<?php

namespace BCache\App\Application;

use BCache\Libs\Exception\Bexception;
class app
{
	public function __construct()
	{

	}

	/**
	 * @brief 开始运行
	 *
	 * @return
	 */
	public function run()
	{
		$this->loadController();
	}

	/**
	 * @brief 加载控制器
	 *
	 * @return
	 */
	private function loadController()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$pattern = '/^\/(.*?)\/(.*?)\/?$/';
		$num = preg_match($pattern, $uri, $match);
		if($num > 0)
		{
			$mux = new \Pux\Mux;
			$_con = $match[1];
			$action = $match[2];
			$con = "BCache\App\Controller\\" . $_con . "Controller";
			if(class_exists($con))
			{
				$controller = new $con();
				$submux = $controller->expand();
				$mux->mount( '/users' , $submux);
				$a = $mux->dispatch('/users/'. $action);
				if(!empty($a))
					\Pux\Executor::execute($a);
				else
					throw new Bexception('没有找到控制器方法');
			}
			else
				throw new Bexception('不存在的控制器');
		}
	}
}
