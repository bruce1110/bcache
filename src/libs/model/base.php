<?php

namespace libs\model;
use libs\cached\mCached;
use libs\db\my;
abstract class base
{
	private $data = array();
	public function __construct($id)
	{
		if(empty($id))
		{

		}
		else
		{
			$this->setId($id);
			$this->load();
		}
	}
	private function setId($id)
	{
		$this->id = $id;
	}
	private function getId()
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
	//数据加载		
	private function load()
	{
		$m = new mCached();
		$this->data = $m->get($this->id);
		var_dump($this->data);
		if(empty($this->data))
		{
			$my = new my();
			$this->data = $my->getDataById($this->tablename, $this->id);
			$m->set($this->id, $this->data);
		}
	}
}
