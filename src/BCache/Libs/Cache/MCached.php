<?php

namespace BCache\Libs\Cache;
use BCache\Libs\Configs\Config;
use memcached;

class MCached
{
	private $cache;
	private $expire = 0;
	private $options = array();
	private $driver = 'memcached';
	private $servers = array();
	public function __construct()
	{
		$this->connect();
	}

	public function connect()
	{
		if($this->driver == 'memcached')
		{
			$this->servers = config::getServers($this->driver);
			$this->options = config::getOptions();
			$this->cache = new memcached();
			$this->cache->setOptions($this->options);
			$this->cache->addServers($this->servers);
		}
	}

	public function get($k)
	{
		$value = $this->cache->get($k);
		if($this->cache->getResultCode() == Memcached::RES_SUCCESS)
			return $value;
		else
			return false;
	}

	public function set($k, $v, $expire = 0)
	{
		$this->cache->set($k, $v, $expire);
		return $this->cache->getResultCode();
	}

	public function del($key)
	{
		$this->cache->delete($key);
	}

	public function dget($k)
	{
		$value = $this->cache->get($k);
		$this->cache->delete($k);
		if($this->cache->getResultCode() == Memcached::RES_SUCCESS)
			return $value;
		else
			return false;
	}
}
