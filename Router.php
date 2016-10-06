<?php
/**
* File name: Router.php
* Class name: Router Class
* Author: Aji Prastiya a.k.a areg_noid | areg_noid@yahoo.com
* @param :all for alphanumeric and dash "-"
* @param :num for numeric
* @param :alpha for alphabeth
*/

class Router {
	private $valRoutes = null;

	public function match($uri) 
	{
		$result = '';
		foreach ($GLOBALS['routes'] as $key => $value) {

			// replace slash with black slash and slash
			$preg_key = str_replace('/', '\/', $key);
			
			$preg_key = str_replace(':all', '([a-zA-Z0-9\.\-]+)', $preg_key);
			$preg_key = str_replace(':num', '([0-9]+)', $preg_key);
			$preg_key = str_replace(':alpha', '([a-zA-Z]+)', $preg_key);
			if(preg_match("/$preg_key/", $uri, $match_route)) {
				$this->valRoutes = $GLOBALS['routes'][$key];

				// advance checking
				// Fix bug
				$temp_uri = str_replace($match_route[0], '', $uri);
				if(strlen($temp_uri) > 1) {
					continue;
				}
				else {
					$result = self::getControllerMethodParams($match_route);
					break;
				}
			}
		}
		return $result;
	}

	/**
	* Based for the value of routes that matches
	* using this method for init controller, method, and params
	* @param array $mathc_route
	* @return array
	*/
	private function getControllerMethodParams($match_route)
	{
		$controller = '';
		$method     = '';
		$params     = [];

		$split = explode('/', $this->valRoutes);
		$split = array_reverse($split);

		foreach ($split as $key => $value) {
			if(preg_match('/\#[0-9]+/', $value)) {
				// init params
				$params[] = $value;
				unset($split[$key]);
				continue;
			}
			else {
				// init method
				$method = $value;
				unset($split[$key]);
				break;
			}
		}
		
		// init controller
		if(count($split) > 1) {
			$split = array_reverse($split);
			$controller = implode('/', $split);
		}
		else {
			$controller = reset($split);
		}

		// revers params
		$params = array_reverse($params);

		// init params
		if(count($match_route) > 1) {
			unset($match_route[0]);
			foreach ($params as $key => $value) {
				$params[$key] = $match_route[$key+1];
			}
		}

		return [
			'controller' => $controller,
			'method'     => $method,
			'params'     => $params,
		];

	}

}
