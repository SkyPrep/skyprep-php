<?php
	/**
		SkyPrep PHP API Wrapper
	*/
	define('BASE_URI', 'https://api.skyprepapp.com/admin/api/');

	use GuzzleHttp\Client;
	include(dirname(__FILE__) .'/guzzle.phar');

	class SkyPrepApi {

		private $getFuncs  = [ 
		"get_user_course_status", 
		"get_login_key", 
		"get_user_courses", 
		"get_user_groups", 
		"get_user_group", 
		"get_course_progress", 
		"test_connection", 
		"get_users", 
		"get_user", 
		"get_materials", 
		"get_courses", 
		"get_course" 
		];
		private $postFuncs = [ 
		"enroll_user_in_courses", 
		"enroll_user_in_courses", 
		"remove_user_from_course", 
		"create_user", 
		"update_user", 
		"destroy_user", 
		"create_course", 
		"update_course", 
		"destroy_course",
		"destroy_courses",
		"destroy_users",
		"destroy_user_groups",
		"create_user_group"
		];

		private $client;
		private $apiKey;
		private $acctKey;


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
	   		if (in_array($snakeName, $this->getFuncs)) {
	   			return $this->get($snakeName, $args[0]);
	   		}

	   		if (in_array($functionName, $this->getFuncs)) {
	   			return $this->get($functionName, $args[0]);
	   		}



	   		if (in_array($snakeName, $this->postFuncs)) {
	   			return $this->post($snakeName, $args[0]);
	   		}

	   		if (in_array($functionName, $this->postFuncs)) {
	   			return $this->post($functionName, $args[0]);
	   		}

	    }

		private function post($url, $params) {
			$params['api_key'] = $this->apiKey;
			$params['acct_key'] = $this->acctKey;
			try {
				$res = $this->client->post($url, array("query" => $params));
				return json_decode($res->getBody(), true);
			} catch(Exception $e) {
				throw new Exception("Issue connecting to API. Please check all parameters");
			}

		}

		private function get($url, $params=array()) {
			$params['api_key'] = $this->apiKey;
			$params['acct_key'] = $this->acctKey;
			try {
				$res = $this->client->get($url, array("query" => $params));
				return json_decode($res->getBody(), true);
			} catch(Exception $e) {
				throw new Exception("Issue connecting to API. Please check all parameters");
			}
		}

	}

?>