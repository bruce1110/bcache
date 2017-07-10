<?php
class UserPlugin extends Yaf\Plugin_Abstract {

	public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		/* var_dump($request->isPost()); */
		/* echo "<br/>"; */
		echo "Plugin routerStartup called <br/>\n";
	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		echo "Plugin routerShutdown called <br/>\n";
	}

	public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	    echo "Plugin DispatchLoopStartup called <br/>\n";
	}

	public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	    echo "Plugin PreDispatch called <br/>\n";
	}

	public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	    echo "Plugin postDispatch called <br/>\n";
	}

	public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	    echo "Plugin DispatchLoopShutdown called <br/>\n";
	}
}
