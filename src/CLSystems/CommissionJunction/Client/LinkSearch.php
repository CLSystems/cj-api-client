<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 12/19/14
 * Time: 1:02 PM
 */

namespace CLSystems\CommissionJunction\Client;

use CLSystems\CommissionJunction\Client as CJClient;

class LinkSearch extends CJClient
{
    const SUBDOMAIN = 'link-search';

    public function __construct($auth_token)
    {
        parent::__construct($auth_token, self::SUBDOMAIN, 'v2');
    }

    public function getLinks(int $websiteId, array $params = [])
	{
		$response = $this->get('link-search?website-id=' . $websiteId, [
			'query' => $params
		]);

		return $response->xml();
	}

    public function getPostings($params = [])
    {
        $response = $this->get('commissions?date-type=posting', [
            'query' => $params
        ]);

        return $response->xml();
    }

    public function getEvents($params = [])
    {
        $response = $this->get('commissions?date-type=event', [
            'query' => $params
        ]);

        return $response->xml();
    }

    public function getItemDetail($original_action_id)
    {
        $response = $this->get('item-detail/' . $original_action_id);

        return $response->xml();
    }

}