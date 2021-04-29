<?php

namespace CLSystems\CommissionJunction;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use SimpleXMLElement;

/**
 * Class Client
 *
 * @package CLSystems\CommissionJunction
 */
class Client extends GuzzleClient
{
	/**
	 * Client constructor.
	 *
	 * @param string $authToken
	 * @param string $subdomain
	 * @param string $version
	 */
	public function __construct(string $authToken, string $subdomain, $version = 'v3')
	{
		$baseUrl = 'https://' . $subdomain . '.api.cj.com/' . $version . '/';
		parent::__construct([
			'headers' => [
				'authorization' => 'Bearer ' . $authToken,
			],
			'base_uri' => $baseUrl,
			'verify' => false,
			'options' => [],
		]);
	}

	/**
	 * @param Response $httpResponse
	 * @param $xmlRecordTag
	 * @return array
	 */
	protected function responseToRecords(Response $httpResponse, $xmlRecordTag) : array
	{
		// parse response body
		$xml = simplexml_load_string($httpResponse->getBody()->getContents());
		if (false === $xml)
		{
			foreach (libxml_get_errors() as $error)
			{
				echo "\t", $error->message . PHP_EOL;
			}
		}
		$records = [];
		if ($xml instanceof SimpleXMLElement)
		{
			// convert xml to an array
			$arr = @json_decode(@json_encode($xml), true);
			if (isset($arr[$xmlRecordTag]))
			{
				$records = $arr[$xmlRecordTag];
			}
			// normalize the result array if we have a single result
			if (is_array($arr) && !array_key_exists(0, $records))
			{
				$records = [$arr];
			}

			if (!is_array($records))
			{
				$records = [$records];
			}

			if (1 === count($records))
			{
				$records = reset($records);
			}
		}
		else
		{
			echo "CJ - FALSE ELSE" . PHP_EOL;
			foreach (libxml_get_errors() as $error)
			{
				echo "\t", $error->message . PHP_EOL;
			}
		}

		return $records;
	}


}
