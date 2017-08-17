<?php

class SoaController extends Yaf\Controller_Abstract
{
	public function initClassAction()
	{
		$classname = $this->getRequest()->getQuery('classname', '');
		if(!empty($classname) && @class_exists($classname))
		{
			$server=new SoapServer(null, array('uri'=>$classname));
			$server->setClass($classname);
			$server->handle();
		}
		return false;
	}
}
