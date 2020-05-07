<?php namespace ATDev\RocketChat;

/**
 * Basic functionality to make a requests to api
 */
abstract class Request {

	/** @var \GuzzleHttp\Client client */
	private static $client;

	/** @var string Chat user id */
	private static $authUserId;

	/** @var string Chat user auth token */
	private static $authToken;

	/** @var string|null Error message, empty if no error, some text if any */
	private $error;

	/**
	 * Inits lib with url to chat instance api
	 * @param string $instance Protocol and domain, i.e. https://chat.me
	 * @param string $root path to api, i.e. /api/v1/
	 * @return null
	 * @throws \Exception
	 */
	public static function init($instance, $root) {

		self::$client = new \GuzzleHttp\Client(["base_uri" => $instance . $root]);
	}

	/**
	 * Sets chat id of user to act as
	 *
	 * @param string $userId Chat user id
	 */
	public static function setAuthUserId($userId) {

		self::$authUserId = $userId;
	}

	/**
	 * Sets chat auth token of user to act as
	 *
	 * @param string $authToken Chat user auth token
	 */
	public static function setAuthToken($authToken) {

		self::$authToken = $authToken;
	}

	/**
	 * Sends the request to the specified url via specified method with specified data
	 *
	 * @param string $url Url
	 * @param string $method Method
	 * @param array|null $data Data
	 *
	 * @return stdClass|false
	 *
	 * @throws \Exception
	 */
	protected static function send($url, $method = "GET", $data = null) {

		if ( empty(self::$client) ) {

			throw new \Exception("You should init first");
		}

		// Get request options
		$options = self::getRequestOptions($method, $data);

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
	 * Gets result by http code and response body
	 *
	 * @param int $code
	 * @param string $body
	 *
	 * @return stdClass|false
	 */
	private static function getResult($code, $body) {

		if ( ( $code >= 200 ) && ($code < 300) ) {

			return @json_decode($body);
		} else {

			return false;
		}
	}

	/**
	 * Gets options for request for guzzle version specifically
	 *
	 * @param string $method
	 * @param array|null $data
	 *
	 * @return array
	 */
	private static function getRequestOptions($method, $data) {

		// Default request parameters
		$options = [
			"timeout" => 60,
			"connect_timeout" => 60,
			"exceptions" => false
		];

		// Set data
		if (($method == "GET") && (!empty($data))) {

			$options["query"] = $data;
		}

		if (($method == "POST") && (!empty($data))) {

			$options["json"] = $data;
		}

		// Set authorization headers
		$headers = [];

		if (!empty(self::$authUserId) ) {

			$headers["X-User-Id"] = self::$authUserId;
		}

		if (!empty(self::$authToken) ) {

			$headers["X-Auth-Token"] = self::$authToken;
		}

		if (!empty($headers) ) {

			$options["headers"] = $headers;
		}

		return $options;
	}

	/**
	 * Gets error
	 *
	 * @return string
	 */
	public function getError() {

		return $this->error;
	}

	/**
	 * Sets error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Request
	 */
	protected function setError($error) {

		$this->error = $error;

		return $this;
	}
}