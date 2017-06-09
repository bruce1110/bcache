<?php
namespace BCache\Libs\Db;

use BCache\Libs\Configs\Config;
use PDO;


class My
{
	private static $Dsn;
	private static $DBUser;
	private static $DBPassword;
	private static $pdo = null;
	private $sQuery;
	private $bConnected = false;
	private $parameters;
	public $rowCount   = 0;
	public $columnCount   = 0;
	public $querycount = 0;


	public function __construct()
	{
		
		$this->Connect();
		$this->parameters = array();
	}


	private function Connect()
	{
		try {
			if( !self::$pdo instanceof PDO ){
				$configs = config::getMysqls();
				self::$Dsn       = $configs['dsn'];
				self::$DBUser     = $configs['user'];
				self::$DBPassword = $configs['passwd'];
				self::$pdo = new PDO(self::$Dsn,
						self::$DBUser, 
						self::$DBPassword,
						array(
							//For PHP 5.3.6 or lower
							PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
							PDO::ATTR_EMULATE_PREPARES => false,
							//长连接
							//PDO::ATTR_PERSISTENT => true,
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
						     )
						);
			}
			/*
			//For PHP 5.3.6 or lower
			$this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
			$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true);//长连接
			$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			 */
		}
		catch (PDOException $e) {
			echo $this->ExceptionLog($e->getMessage());
			die();
		}
	}


	public function CloseConnection()
	{
		self::$pdo = null;
	}


	private function Init($query, $parameters = "")
	{
		if (!$this->bConnected) {
			$this->Connect();
		}
		try {
			$this->parameters = $parameters;
			$this->sQuery     = self::$pdo->prepare($this->BuildParams($query, $this->parameters));

			if (!empty($this->parameters)) {
				if (array_key_exists(0, $parameters)) {
					$parametersType = true;
					array_unshift($this->parameters, "");
					unset($this->parameters[0]);
				} else {
					$parametersType = false;
				}
				foreach ($this->parameters as $column => $value) {
					$this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column]); //It would be query after loop end(before 'sQuery->execute()').It is wrong to use $value.
				}
			}

			$this->succes = $this->sQuery->execute();
			$this->querycount++;
		}
		catch (PDOException $e) {
			echo $this->ExceptionLog($e->getMessage(), $this->BuildParams($query));
			die();
		}

		$this->parameters = array();
	}

	private function BuildParams($query, $params = null)
	{
		if (!empty($params)) {
			$rawStatement = explode(" ", $query);
			foreach ($rawStatement as $value) {
				if (strtolower($value) == 'in') {
					return str_replace("(?)", "(" . implode(",", array_fill(0, count($params), "?")) . ")", $query);
				}
			}
		}
		return $query;
	}


	public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$query        = trim($query);
		$rawStatement = explode(" ", $query);
		$this->Init($query, $params);
		$statement = strtolower($rawStatement[0]);
		if ($statement === 'select' || $statement === 'show') {
			return $this->sQuery->fetchAll($fetchmode);
		} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
			return $this->sQuery->rowCount();
		} else {
			return NULL;
		}
	}


	public function lastInsertId()
	{
		return self::$pdo->lastInsertId();
	}


	public function column($query, $params = null)
	{
		$this->Init($query, $params);
		$resultColumn = $this->sQuery->fetchAll(PDO::FETCH_COLUMN);
		$this->rowCount = $this->sQuery->rowCount();
		$this->columnCount = $this->sQuery->columnCount();
		$this->sQuery->closeCursor();
		return $resultColumn;
	}
	public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$this->Init($query, $params);
		$resultRow = $this->sQuery->fetch($fetchmode);
		$this->rowCount = $this->sQuery->rowCount();
		$this->columnCount = $this->sQuery->columnCount();
		$this->sQuery->closeCursor();
		return $resultRow;
	}


	public function single($query, $params = null)
	{
		$this->Init($query, $params);
		return $this->sQuery->fetchColumn();
	}


	private function ExceptionLog($message, $sql = "")
	{
		$exception = 'Unhandled Exception. <br />';
		$exception .= $message;
		$exception .= "<br /> You can find the error back in the log.";

		if (!empty($sql)) {
			$message .= "\r\nRaw SQL : " . $sql;
		}
		$this->log->write($message, $this->DBName . md5($this->DBPassword));
		//Prevent search engines to crawl
		header("HTTP/1.1 500 Internal Server Error");
		header("Status: 500 Internal Server Error");
		return $exception;
	}

	public function getDataById($tableName, $id)
	{
		$sql = 'SELECT * FROM ' . $tableName . ' WHERE id = ?';
		$re = $this->row($sql, array($id));
		return empty($re) ? array() : $re;
	}

	public function updateById($tableName, $id, $value)
	{
		$keys = array_keys($value);
		$params = array_values($value);
		$params[] = $id;
		foreach($keys as &$v)
		{
			$v = $v . '=?';
		}
		$query = 'UPDATE ' . $tableName . ' SET ' . implode(',', $keys) . ' WHERE id = ?';
		return $this->query($query, $params);
	}

	public function insertData($tableName, $value)
	{
		$keys = array_keys($value);
		$params = array_values($value);
		$query = 'INSERT INTO ' . $tableName . '(' . implode(',',$keys) . ') VALUES(' . implode(',',array_fill(0, count($keys), '?')) . ')';
		return $this->query($query, $params);
	}

	/**
	 * @brief 根据条件查询相应的字段 
	 *
	 * @params $tableName
	 * @params $fields
	 * @params $where
	 * @params $order
	 * @params $limit
	 * @params $params
	 *
	 * @return
	 */
	public function getOrderDataByWhere($tableName, $fields, $where, $order, $limit, $params)
	{
		$fields_str = implode($fields, ',');
		$where_str = implode($where, ' = ? and ') . ' = ?';
		$order_str = str_replace('_', ' ', implode($order, ','));
		$where_value = array();
		foreach($where as $v)
		{
			if(isset($params[$v]))
				$where_value[] = $params[$v];
			else
				throw new \exception('字段名称有误');
		}
		$limit_str = '';
		if(!empty($limit))
			$limit_str = ' LIMIT ' . implode($limit, ',');
		$sql = 'SELECT '. $fields_str . ' FROM ' . $tableName . ' WHERE ' . $where_str . ' ORDER BY ' . $order_str . $limit_str;
		return $this->query($sql, $where_value);
	}
}
