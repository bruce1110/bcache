<?php

class service_Base
{
	private $location = 'http://bruce.net/soa/initclass';
	protected $classname;
	public function __construct()
	{
		
	}

	public function getClient($name)
	{
		try{
			$soap = new SoapClient(null,array(
						"location" => $this->location . '?classname=' . $name,
						"uri"      => $name  //资源描述符服务器和客户端必须对应
						));
			$soap->soap_defencoding = 'utf-8'; 
			$soap->decode_utf8 = false;
			return $soap;
		}catch(Exction $e){
			echo print_r($e->getMessage(),true);
		}
	}
}
