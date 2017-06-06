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
use BCache\App\Entity\Users;

abstract class MapperBase
{
	
	private $cache = null;
	private $my = null;
	private $data = array();
	public function __construct()
	{
		$this->cache = new MCached();
		$this->my = new My();
	}

	public function __call($name, $parms)
	{
		/* if(strcmp($name, 'find_all_by_id') == 0) */
		/* { */
		/* 	$this->getDataById($parms[0]); */
		/* 	//装载数据 */
		/* 	$obj = $this->load(); */
		/* 	return $obj; */
		/* } */
		/* else */
		/* { */
			preg_match( "/^find_([\w]*)_by_([\w]*)_order_by_([\w]*)$/",  $name, $match1);
			preg_match( "/^find_([\w]*)_by_([\w]*)$/",  $name, $match2);
			if(!empty($match1))
				$match = $match1;
			elseif(!empty($match2))
				$match = $match2;
			else
				throw new \exception('不存在的方法');
			$this->getDataFromMy($match, $parms);
			return $this->load();
		/* } */
	}

	public function __set($name, $value)
	{
		//
	}

	/**
	 * @brief 返回对象数组
	 * 如果只有一个元素，返回一个对象
	 *
	 * @return
	 */
	private function load()
	{
		if(empty($this->data))
			return null;
		$objArray = array();
		foreach($this->data as $data)
		{
			//放入缓存
			$this->cache->set($data['id'], $data);
			$obj = new Users($data['id']);
			foreach($data as $k=>$v)
			{
				if(strcmp($k, 'id') !== 0)
					$obj->$k = $v;
			}
			$objArray[] = $obj;
		}
		return count($objArray) == 1 ? array_pop($objArray) : $objArray;
	}

	private function getDataById($id)
	{
		$this->data = $this->cache->get($id);
		if(empty($this->data))
		{
			$this->data = $this->my->getDataById($this->table,$id);
			$this->cache->set($id, $this->data);
		}
	}

	/**
	 * @brief 保存数据
	 *
	 * @params $obj
	 *
	 * @return
	 */
	public function save(EntityBase $obj)
	{
		$data = array();
		foreach($this->data as $k=>$v)
		{
			if(strcmp($obj->$k, $v) !== 0)
				$data[$k] = $obj->$k;
		}
		return $this->my->updateById($this->table, $obj->getId(), $data);
	}

	/**
	 * @brief 从数据库查找
	 *
	 * @params $match
	 * @params $params
	 *
	 * @return
	 */
	private function getDataFromMy($match, $params)
	{
		if($match[1] == 'all')
		{
			$limit = array();
			$fields = array('*');
		}
		else
		{
			$limit = array(0,1);
			$fields = array('*');
		}
		$where = explode('_and_' , $match[2]);
		if(isset($match[3]))
			$order = explode('_and_', $match[3]);
		else
			$order = explode('_and_', 'id_desc');//默认按照id降序排列
		//根据id查找的时候，先查找cache
		if(empty(array_diff($where, array('id'))))
		{
			$cache = $this->cache->get($params[0]['id']);
			if(!empty($cache))
				$this->data[] = $cache;
		}
		if(empty($this->data))
		{
			$this->data = $this->my->getOrderDataByWhere($this->table, $fields, $where, $order, $limit, $params[0]);
			//写入cache,循环写入
			if(!empty($this->data))
			{
				foreach($this->data as $v)
					$this->cache->set($v['id'], $v);
			}
		}
	}
}
