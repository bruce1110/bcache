<?php
namespace Bcache\App\Smarty;


class Smarty
{
	private $cache_dir = '';
	public function __construct()
	{
		define('REAL_PATH', dirname(__FILE__));
		$_smarty=new \Smarty;

		$_smarty->setCacheDir(REAL_PATH.'/cache');
		$_smarty->setConfigDir(REAL_PATH.'/configs');
		/* $_smarty->setPluginsDir(REAL_PATH.'/plugins'); */
		$_smarty->setTemplateDir(REAL_PATH.'/templates');
		$_smarty->setCompileDir(REAL_PATH.'/templates_c');

		//添加Smarty自带的插件库
		 /* $_smarty->addPluginsDir(REAL_PATH.'/smarty/plugins'); */ 

		//检测Smarty目录结构配置是否有效
		$_smarty->testInstall();
	}
}
