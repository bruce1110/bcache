<?php

namespace BCache\Libs\Exception;

class Bexception extends \Exception
{
	public function  __construct ($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}

}
