<?php

namespace BCache\App\Application;
use BCache\App\Application\start;
class init
{
	private static $_app;
	public function __construct()
	{

	}

	public static function start()
	{
		self::register_error_exception();
		self::$_app = new start();
		return self::$_app;
	}

	private static function end()
	{
		exit(1);
	}

	private static function register_error_exception()
	{
		set_exception_handler(array("\BCache\App\Application\init", "handlerException"));
		set_error_handler(array("\BCache\App\Application\init", "handlerError"));
	}

	public static function handlerException($exception)
	{
		restore_error_handler();
		restore_exception_handler();
		$message = $exception->__toString();
		echo $message;
	}

	public static function handlerError($code, $message, $file, $line)
	{
		restore_error_handler();        
		restore_exception_handler();    
		$log="$message ($file:$line)\nStack trace:\n";
		$trace=debug_backtrace();       
		// skip the first 3 stacks as they do not tell the error position
		if(count($trace)>3)             
			$trace=array_slice($trace,3);   
		foreach($trace as $i=>$t)       
		{                               
			if(!isset($t['file']))          
				$t['file']='unknown';           
			if(!isset($t['line']))          
				$t['line']=0;                   
			if(!isset($t['function']))      
				$t['function']='unknown';       
			$log.="#$i {$t['file']}({$t['line']}): ";
			if(isset($t['object']) && is_object($t['object']))
				$log.=get_class($t['object']).'->';
			$log.="{$t['function']}()\n";   
		}                               
		if(isset($_SERVER['REQUEST_URI']))
			$log.='REQUEST_URI='.$_SERVER['REQUEST_URI'];
		/* LG::log('HandleError')->error($log); */
		echo $log;
	}
}
