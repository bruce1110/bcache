<?php
namespace BCache\Libs\Configs;
use BCache\Libs\Exception\Bexception;
class Config
{
	private static $configs = null;
	public static function getServers($driver)
	{
		self::$configs = empty(self::$configs)?parse_ini_file(ROOT . '/configs/config.ini', true) : self::$configs;
		$servers = array();
		foreach(self::$configs[$driver] as $v)
		{
			$servers[] = array($v['host'], $v['port'], $v['weight']);
		}
		return $servers;
	}


	public static function getOptions()
	{
		$options = array(
				\Memcached::OPT_DISTRIBUTION=>\Memcached::DISTRIBUTION_CONSISTENT,
				\Memcached::OPT_LIBKETAMA_COMPATIBLE=>true,
				\Memcached::OPT_COMPRESSION=>true,
				\Memcached::OPT_SERIALIZER=>\Memcached::SERIALIZER_PHP
				);
		return $options;
	}

	public static function getMysqls()
	{
		self::$configs = empty(self::$configs)?parse_ini_file(ROOT . '/configs/config.ini', true) : self::$configs;
		return self::$configs['mysqld'];
	}

	public static function getConfigs($k)
	{
		self::$configs = empty(self::$configs)?parse_ini_file(ROOT . '/configs/config.ini', true) : self::$configs;
		$config = isset(self::$configs[$k])&&!empty(self::$configs[$k]) ? self::$configs[$k] : null;
		if(empty($config))
			throw new Bexception('配置载入失败');
		else
			return $config;
	}
}
