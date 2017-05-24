<?php

namespace libs\model;

class model
{
	protected $id;
	protected $table = array();
	protected $tablename = '';
	public function __construct()
	{
		$this->tablename = get_class();
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}
	public function __get($name)
	{
		if(isset($this->table[$name]))
			return $this->table[$name];
		else
			return false;
	}
	public function __set($name,$value)
	{
		if(isset($this->table[$name]))
			$this->table[$name] = $value;
	}
}
