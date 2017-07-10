<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */		
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
class IndexController extends Yaf\Controller_Abstract {

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/byaf/index/index/index/name/root 的时候, 你就会发现不同
     */
	public function indexAction($name = "Stranger") {
		
		//1. fetch query
		$get = $this->getRequest()->getQuery("get", "default value");

		//2. fetch model
		$model = new SampleModel();

		//3. assign
		$this->getView()->assign("content", $model->selectSample());
		$this->getView()->assign("name", $name);
		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
	}

	public function testAction()
	{
		// Create the logger
		/* $logger = new Logger('my_logger'); */
		/* // Now add some handlers */
		/* $logger->pushHandler(new StreamHandler('/tmp/your.log', Logger::DEBUG)); */
		/* $logger->pushHandler(new FirePHPHandler()); */

		/* // You can now use your logger */
		/* $logger->info('My logger is now ready'); */
		Yaf\Application::app()->getDispatcher()->returnResponse(TRUE);//关闭自动响应
		$this->getView()->assign('date', date('Y-m-d'));
		/* $view = $this->getView(); */
		/* var_dump($view); */
		/* return false; */
		/* $response = $this->getResponse()->response(); */
		$this->display("test");
		return false;
	}

	public function forwardAction()
	{
		echo __METHOD__, "<br/><hr/>";
		return false;
	}

	/**
	 * @brief 首先请求
	 *
	 * @return
	 */
	private function init()
	{
		if($this->getRequest()->isXmlHttpRequest())
		{
			Yaf\Application::app()->getDispatcher()->disableView();
		}
	}
}
