<?php
/**
 * @file MapperBase.php
 * @brief 数据映射器是一个负责将数据库中的一行数据映射到一个对象的类
 * @author Bruce
 * @version 1
 * @date 2017-06-02
 */

namespace BCache\Libs\Mapper;
use BCache\Libs\Cache\MCached;
use BCache\Libs\Db\My;
use BCache\Libs\Entity\EntityBase;

abstract class MapperBase
{
	
	private $cache = null;
	private $my = null;
	public function __construct()
	{
		$this->cache = new MCached();
		$this->my = new My();
	}

	public function __call($name, $parms)
	{
		echo $name;
	}

	public function __set($name, $value)
	{
		//
	}
}
