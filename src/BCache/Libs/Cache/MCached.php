<?php

namespace BCache\Libs\Cache;
use BCache\Libs\Configs\Config;
use memcached;

class MCached
{
	private static $cache = null;
	private $expire = 0;
	private $options = array();
	private $driver = 'memcached';
	private $servers = array();
	public function __construct()
	{
		if(empty(self::$cache))
			$this->connect();
	}

	public function connect()
	{
		if($this->driver == 'memcached')
		{
			$this->servers = config::getServers($this->driver);
			$this->options = config::getOptions();
			self::$cache = new memcached();
			self::$cache->setOptions($this->options);
			self::$cache->addServers($this->servers);
		}
	}

	public function get($k)
	{
		$value = self::$cache->get($k);
		if(self::$cache->getResultCode() == Memcached::RES_SUCCESS)
			return $value;
		else
			return false;
	}

	public function set($k, $v, $expire = 0)
	{
		self::$cache->set($k, $v, $expire);
		return self::$cache->getResultCode();
	}

	public function del($key)
	{
		self::$cache->delete($key);
	}

	public function dget($k)
	{
		$value = self::$cache->get($k);
		self::$cache->delete($k);
		if(self::$cache->getResultCode() == Memcached::RES_SUCCESS)
			return $value;
		else
			return false;
	}
}
