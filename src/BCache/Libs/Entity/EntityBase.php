<?php
/**
 * @file EntityBase.php
 * @brief 实体类
 * @author Bruce
 * @version 1
 * @date 2017-06-02
 */

namespace BCache\Libs\Entity;

abstract class EntityBase
{
	private $id;
	public function __construct($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function __set($name, $value)
	{
		if(property_exists(get_class($this), $name) && $name != 'id')
			$this->$name = $value;
	}

	public function __get($name)
	{
		if(property_exists(get_class($this), $name) && $name != 'id')
			return $this->$name;
	}
}
