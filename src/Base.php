<?php namespace ATDev\RocketChat;

abstract class Base {

	private static $client;
	private static $authUserId;
	private static $authToken;

	public static function init($instance, $root) {

		if ( class_exists("\GuzzleHttp\Client") ) {
			// Guzzle 6
			self::$client = new \GuzzleHttp\Client(array('base_uri' => $instance . $root));
			return;
		}

		if ( class_exists("\Guzzle\Http\Client") ) {
			// Guzzle 3
			self::$client = new \Guzzle\Http\Client($instance . $root);
			return;
		}

		throw new \Exception("Cannot initiate guzzle");
	}

	protected static function setAuthUserId($userId) {

		self::$authUserId = $userId;
	}

	protected static function setAuthToken($authToken) {

		self::$authToken = $authToken;
	}

	protected static function send($url, $method = "GET", $data = null) {

		if ( empty(self::$client) ) {

			throw new \Exception("You should init first");
		}

		if ( self::$client instanceof \GuzzleHttp\Client) {

			return self::send6($url, $method, $data);
		}

		if ( self::$client instanceof \Guzzle\Http\Client) {

			return self::send3($url, $method, $data);
		}

		throw new \Exception("Unknown guzzle version");
    }

	private static function send3($url, $method, $data) {

		// Get request options
		$options = self::getRequestOptions($method, $data, 3);

		$request = self::$client->createRequest($method, $url, array(), null, $options);

		// Do request
		$res = $request->send();

		$code = $res->getStatusCode();
		$body = $res->getBody();

		return self::getResult($code, $body);
    }

	private static function send6($url, $method, $data) {

		// Get request options
		$options = self::getRequestOptions($method, $data, 6);

		// Do request
		$res = self::$client->request(
			$method,
			$url,
			$options
		);

		$code = $res->getStatusCode();
		$body = $res->getBody()->getContents();

		return self::getResult($code, $body);
    }

	private static function getResult($code, $body) {

		if ( ( $code >= 200 ) && ($code < 300) ) {

			return json_decode($body);
		} else {

			return false;
		}
	}

	private static function getRequestOptions($method, $data, $version = 6) {

		// Default request parameters
		$options = array("timeout" => 60, "connect_timeout" => 60, "exceptions" => false);

		// Set data
		if ( ( $method == "GET" ) && ( ! empty($data) ) ) {

			$options["query"] = $data;
		}
		if ( ( $method == "POST" ) && ( ! empty($data) ) ) {

			if ( $version == 6) {

				$options["json"] = $data;
			} else {

				$options["body"] = json_encode($data);
			}
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

			$options["headers"] = $headers;
		}

		return $options;
	}
}