<?php namespace ATDev\RocketChat;

/**
 * An abstract class for inheritance
 * Has methods to do the requests to api
 */
abstract class Base {

	/** @var \GuzzleHttp\Client|\Guzzle\Http\Client Guzzle client */
	private static $client;
	/** @var string Chat user id */
	private static $authUserId;
	/** @var string Chat user auth token */
	private static $authToken;

	/**
	 * Inits lib with url to chat instance api
	 * @param string $instance Protocol and domain, i.e. https://chat.here
	 * @param string $root apth to apim i.e. /api/v1/
	 * @return null
	 * @throws \Exception
	 */
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

	/**
	 * Sets chat user id on login
	 * @param string $userId Chat user id
	 */
	protected static function setAuthUserId($userId) {

		self::$authUserId = $userId;
	}

	/**
	 * Sets chat user auth token on login
	 * @param string $authToken Chat user auth token
	 */
	protected static function setAuthToken($authToken) {

		self::$authToken = $authToken;
	}

	/**
	 * Sends the request to the specified url via specified method with specified data
	 * @param string $url Url
	 * @param string $method Method
	 * @param array|null $data Data
	 * @return stdClass|false
	 * @throws \Exception
	 */
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

	/**
	 * Sends the request to the specified url via specified method with specified data via Guzzle3
	 * @param string $url Url
	 * @param string $method Method
	 * @param array|null $data Data
	 * @return stdClass|false
	 * @throws \Exception
	 */
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

	/**
	 * Sends the request to the specified url via specified method with specified data via Guzzle6
	 * @param string $url Url
	 * @param string $method Method
	 * @param array|null $data Data
	 * @return stdClass|false
	 * @throws \Exception
	 */
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

	/**
	 * Gets result by http code ans response body
	 * @param int $code
	 * @param string $body
	 * @return stdClass|false
	 */
	private static function getResult($code, $body) {

		if ( ( $code >= 200 ) && ($code < 300) ) {

			return json_decode($body);
		} else {

			return false;
		}
	}

	/**
	 * Gets options for request for guzzle version specifically
	 * @param string $method
	 * @param array|null $data
	 * @param 3|6 $version
	 * @return array
	 */
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