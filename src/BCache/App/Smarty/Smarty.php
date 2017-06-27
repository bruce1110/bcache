<?php
namespace Bcache\App\Smarty;


class Smarty
{
	private $cache_dir = '';
	private $_smarty = null;
	public function __construct()
	{
		if(!defined('REAL_PATH'))
			define('REAL_PATH', dirname(__FILE__));
		$this->_smarty=new \Smarty;

		$this->_smarty->setCacheDir(REAL_PATH.'/cache');
		$this->_smarty->setConfigDir(REAL_PATH.'/configs');
		/* $_smarty->setPluginsDir(REAL_PATH.'/plugins'); */
		$this->_smarty->setTemplateDir(REAL_PATH.'/templates');
		$this->_smarty->setCompileDir(REAL_PATH.'/templates_c');

		//添加Smarty自带的插件库
		 /* $_smarty->addPluginsDir(REAL_PATH.'/smarty/plugins'); */ 

		//检测Smarty目录结构配置是否有效
		/* $_smarty->testInstall(); */
	}

	public function get()
	{
		return $this->_smarty;
	}
}
