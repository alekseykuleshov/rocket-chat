<?php namespace ATDev\RocketChat;

abstract class Base {

	private static $client;
	private static $authUserId;
	private static $authToken;

	public static function init($instance, $root) {

		self::$client = new \GuzzleHttp\Client(['base_uri' => $instance . $root]);
	}

	protected static function setAuthUserId($userId) {

		self::$authUserId = $userId;
	}

	protected static function setAuthToken($authToken) {

		self::$authToken = $authToken;
	}

	protected static function send($url, $method = "GET", $data = null) {

		if ( empty(self::$client) ) {

			throw new Exception("You should init first");
		}

		// Default request parameters
		$params = array("timeout" => 60, "connect_timeout" => 60, "exceptions" => false);

		// Set data
		if ( ( $method == "GET" ) && ( ! empty($data) ) ) {

			$params["query"] = $data;
		}
		if ( ( $method == "POST" ) && ( ! empty($data) ) ) {

			$params["json"] = $data;
		}

		// Set authorization headers
		$headers = array();
		if ( ! empty(self::$authUserId) ) {

			$headers["X-User-Id"] = self::$authUserId;
		}
		if ( ! empty(self::$authToken) ) {

			$headers["X-Auth-Token"] = self::$authToken;
		}

		if ( ! empty($headers) ) {

			$params["headers"] = $headers;
		}

		// Do request
		$res = self::$client->request(
			$method,
			$url,
			$params
		);

		$code = $res->getStatusCode();
		$body = $res->getBody()->getContents();

		if ( ( $code >= 200 ) && ($code < 300) ) {

			return json_decode($body);
		} else {

			return false;
		}
    }
}