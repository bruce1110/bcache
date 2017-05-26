<?php

namespace BCache\Libs\Model;
use BCache\Libs\Cache\MCached;
use BCache\Libs\Db\My;
use BCache\Libs\UUId\IdCreate;

abstract class ModelBase
{
	
	private $data = array();//从缓存或者数据库读取的数据
	private $m = null;
	private $my = null;
	private $insert = array();//插入的数据
	private $update = array();//更新的数据
	private $add = false;

	/**
	 * @brief 
	 *
	 * @params $id
	 *
	 * @return 
	 */
	public function __construct($id)
	{
		$this->m = new mCached();
		$this->my = new my();
		if(empty($id))
		{
			$this->createId();
		}
		else
		{
			$this->setId($id);
			$this->load();
		}
	}

	/**
	 * @brief 设置主键
	 *
	 * @params $id
	 *
	 * @return 
	 */
	private function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @brief 生成唯一id ,并将id放入待插入数组
	 *
	 * @return 
	 */
	private function createId()
	{
		$this->add = true;
		$this->id = idCreate::get();
		$this->insert['id'] = $this->id;
	}

	/**
	 * @brief 获取元素的值
	 *
	 * @params $name
	 *
	 * @return 
	 */
	public function __get($name)
	{
		if(in_array($name, $this->table))
			return $this->data[$name];
		else
			return false;
	}

	/**
	 * @brief 为元素赋值
	 *
	 * @params $name
	 * @params $value
	 *
	 * @return 
	 */
	public function __set($name,$value)
	{
		if(in_array($name, $this->table))
			if($this->add)
				$this->insert[$name] = $value;
			else
				$this->update[$name] = $value;
	}
	
	/**
	 * @brief 从缓存或者数据库加载数据
	 *
	 * @return 
	 */
	private function load()
	{
		$this->data = $this->m->get($this->id);
		if(empty($this->data))
		{
			$this->data = $this->my->getDataById($this->tablename, $this->id);
			$this->m->set($this->id, $this->data);
		}
	}

	/**
	 * @brief 清空缓存
	 *
	 * @return 
	 */
	private function flush()
	{
		if(!empty($this->update))
		{
			$this->m->del($this->id);
		}
	}


	/**
	 * @brief 保存数据
	 *
	 * @return 
	 */
	private function save()
	{
		if(!empty($this->update))
			$this->my->updateById($this->tablename, $this->id, $this->update);
		if(!empty($this->insert))
			$this->my->insertData($this->tablename, $this->insert);
	}

	/**
	 * @brief 析构函数
	 *
	 * @return 
	 */
	public function __destruct()
	{
		$this->flush();
		$this->save();
	}
}
