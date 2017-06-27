<?php
namespace BCache\Libs\Controller;
use Pux\Controller;
use BCache\App\Smarty\Smarty;
class ControllerBase extends Controller
{
	protected $smerty;
	public function __construct()
	{
		$sm = new Smarty();
		$this->smarty = $sm->get();
	}
}
