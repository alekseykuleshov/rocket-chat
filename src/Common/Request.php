<?php namespace ATDev\RocketChat\Common;

/**
 * Basic functionality to make a requests to api
 */
abstract class Request implements \JsonSerializable {

	/** @const string Uri to api */
	const URI = "/api/v1/";

	/** @var string|null Error message, empty if no error, some text if any */
	protected static $error;

	/** @var mixed Api response */
	protected static $response;

	/** @var string Api response code */
	protected static $responseCode;

	/** @var string Last url accessed in case of redirect */
	protected static $responseUrl;

	/** @var boolean Indicates if request was successful */
	protected static $success;

	/** @var \GuzzleHttp\Client client */
	private static $client;

	/** @var string Chat user id */
	private static $authUserId;

	/** @var string Chat user auth token */
	private static $authToken;

	/**
	 * Inits lib with url to chat instance api
	 *
	 * @param string $instance Protocol and domain, i.e. https://chat.me
	 *
	 * @return null
	 */
	public static function init($instance) {

		self::$client = new \GuzzleHttp\Client([
			"base_uri" => $instance . self::URI,
			"allow_redirects" => ["track_redirects" => true]
		]);
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
	 * @param array|null $files Files
	 *
	 * @return boolean
	 *
	 * @throws \Exception
	 */
	protected static function send($url, $method = "GET", $data = null, $files = null) {

		if ( empty(self::$client) ) {

			throw new \Exception("You should init first");
		}

		static::$response = null;
		static::$responseCode = null;
		static::$responseUrl = null;
		static::$success = true;

		// Get request options
		$options = self::getRequestOptions($method, $data, $files);

		// Do request
		$res = self::$client->request( // // TODO: Check api is available, catch the guzzle exception
			$method,
			$url,
			$options
		);

		$headersRedirect = $res->getHeader(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER);
		$responseCode = $res->getStatusCode();
		$responseBody = $res->getBody()->getContents();

		static::$response = @json_decode($responseBody);
		static::$responseCode = $responseCode;
		static::$responseUrl = (!empty($headersRedirect)) ? $headersRedirect[count($headersRedirect) - 1] : null;

		if (isset(static::$response->success) && (!static::$response->success)) {

			if (isset(static::$response->error)) {

				static::setError(static::$response->error);
			} else {

				static::setError("Unknown error occured in api");
			}

			static::$success = false;
		}

		return ((static::$responseCode >= 200) && (static::$responseCode < 300));
	}

	/**
	 * Gets options for request for guzzle version specifically
	 *
	 * @param string $method
	 * @param array|null $data
	 *
	 * @return array
	 */
	private static function getRequestOptions($method, $data, $files) {

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

		if (($method == "POST")) {

			if (!empty($files)) {

				$multipart = [];

				foreach ($files as $key => $value) {

					$multipart[] = [
						"name" => $key,
						"contents" => fopen($value, 'r'), // TODO: Check if file is readable, is_readable function
						"filename" => basename($value)
					];
				}

				if (!empty($data)) {

					foreach ($data as $key => $value) {

						$multipart[] = [
							"name" => $key,
							"contents" => $value
						];
					}
				}

				$options["multipart"] = $multipart;
			} elseif (!empty($data)) {

				$options["json"] = $data;
			}
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
	 * Gets success
	 *
	 * @return string
	 */
	public static function getSuccess() {

		return static::$success;
	}

	/**
	 * Gets response
	 *
	 * @return mixed
	 */
	public static function getResponse() {

		return static::$response;
	}

	/**
	 * Gets response code
	 *
	 * @return integer
	 */
	public static function getResponseCode() {

		return static::$responseCode;
	}

	/**
	 * Gets response url
	 *
	 * @return string
	 */
	public static function getResponseUrl() {

		return static::$responseUrl;
	}

	/**
	 * Gets error
	 *
	 * @return string
	 */
	public static function getError() {

		return static::$error;
	}

	/**
	 * Sets error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Request
	 */
	protected static function setError($error) {

		static::$error = $error;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		return null;
	}
}