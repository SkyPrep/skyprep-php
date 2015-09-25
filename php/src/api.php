<?php
	/**
		SkyPrep PHP API Wrapper
	*/
	require('exception.php');
	define('BASE_URI', 'https://api.skyprep.io/admin/api/');

	use GuzzleHttp\Client;
	include(dirname(__FILE__) .'/guzzle.phar');

	class SkyPrepApi {



		function SkyPrepApi($key, $ak) {
			$this->apiKey = $key;
			$this->acctKey = $ak;
			$this->client = new Client(
				[
				"base_uri" => BASE_URI,
				"auth" => null
				]
			);

		}

		private $getPrefixes = ['get'];
		private $postPrefixes = ['update', 'destroy', 'create'];

		private function _arrayContains($str, $arr) {
			foreach($arr as $a) {
        		if (stripos($str,$a) !== false) return true;
    		}
		    return false;
		}

		private function _snakeToCamel($val) {  
			$val = str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));  
			$val = strtolower(substr($val,0,1)) . substr($val,1);  
			return $val;  
		}

		private function _camelToSnake($val) {  
			return preg_replace_callback('/[A-Z]/', create_function('$match', 'return "_" . strtolower($match[0]);'), $val);  
		} 



	   function __call($functionName, $args) {
	   		$snakeName = $this->_camelToSnake($functionName);
	   		if ($this->_arrayContains($snakeName, $this->postPrefixes)) {
	   			return $this->post($snakeName, $args[0]);
	   		}
	   		return $this->get($snakeName, $args[0]);

	    }

		private function post($url, $params) {
			$params['api_key'] = $this->apiKey;
			$params['acct_key'] = $this->acctKey;
			try {
				$res = $this->client->post($url, array("query" => $params));
				return json_decode($res->getBody(), true);
			} catch(Exception $e) {
				throw new SkyPrepException("Issue connecting to API. Please check all parameters");
			}

		}

		private function get($url, $params=array()) {
			$params['api_key'] = $this->apiKey;
			$params['acct_key'] = $this->acctKey;
			try {
				$res = $this->client->get($url, array("query" => $params));
				return json_decode($res->getBody(), true);
			} catch(Exception $e) {
				throw new SkyPrepException("Issue connecting to API. Please check all parameters");
			}
		}

	}

?>
