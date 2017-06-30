<?php
namespace BCache\Libs\Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use BCache\Libs\Configs\Config;

class Blog 
{
	private static $logconfig = null;
	private static $level = array(
			'DEBUG'=>'Logger::DEBUG'
			,'INFO'=>'Logger::INFO'
			,'NOTICE'=>'Logger::NOTICE'
			,'WARNING'=>'Logger::WARNING'
			,'ERROR'=>'Logger::ERROR'
			,'CRITICAL'=>'Logger::CRITICAL'
			,'ALERT'=>'Logger::ALERT'
			,'EMERGENCY'=>'Logger::EMERGENCY'
			);
	public function __construct()
	{

	}

	/**
	 * @brief 返回日志类实例
	 *
	 * @params $name
	 *
	 * @return
	 */
	public static function out($name = 'Application Exception')
	{
		$logconfig = Config::getConfigs('log');
		if(isset($logconfig['log_level']) && !empty($logconfig['log_level']) && isset(self::$level[strtoupper($logconfig['log_level'])]))
			$loglevel = self::$level[strtoupper($logconfig['log_level'])];
		else
			$loglevel = 'Logger::WARNING';
		if(isset($logconfig['log_path']) && !empty($logconfig['log_path']))
			$logpath = $logconfig['log_path'];
		else
			$logpath = '/tmp/error.log';
		$log = new Logger($name);
		$stream = new StreamHandler($logpath, $loglevel);
		$out = "===\n[%datetime%] %channel%.%level_name%: \n%message% \n%context% %extra%\n===\n";
		$formatter = new LineFormatter($out);
		$stream->setFormatter($formatter);
		$log->pushHandler($stream);
		return $log;
	}
}
