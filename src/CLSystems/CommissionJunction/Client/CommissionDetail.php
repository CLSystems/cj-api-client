<?php

namespace CLSystems\CommissionJunction\Client;

use CLSystems\CommissionJunction\Client as CJClient;

class CommissionDetail extends CJClient
{
    const SUBDOMAIN = 'commission-detail';

    public function __construct($auth_token)
    {
        parent::__construct($auth_token, self::SUBDOMAIN, 'v3');
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