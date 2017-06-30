<?php

namespace BCache\App\Application;
use BCache\App\Application\app;
use BCache\Libs\Exception\Blog;
class init
{
	private static $_app;
	public function __construct()
	{

	}

	public static function start()
	{
		self::register_error_exception();
		self::$_app = new app();
		return self::$_app;
	}

	private static function register_error_exception()
	{
		set_exception_handler(array("\BCache\App\Application\init", "handlerException"));
		set_error_handler(array("\BCache\App\Application\init", "handlerError"), error_reporting());
		register_shutdown_function(array('\BCache\App\Application\init', 'end'));
	}

	public static function handlerException($exception)
	{
		restore_error_handler();
		restore_exception_handler();
		$message = $exception->__toString();
		Blog::out('HandleException')->warning($message);
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
		Blog::out('HandleError')->error($log);
	}

	public static function end()
	{
		$e = print_r(error_get_last()['message'], true);
		if(!empty($e))
			Blog::out('Error')->error($e);
		exit(0);
	}
}
