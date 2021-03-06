<?php

namespace CLSystems\Tests;

use CLSystems\CommissionJunction\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\History;

abstract class ClientTestCase extends \PHPUnit_Framework_TestCase
{
    protected $cj_client;

    protected $mock_response_object;

    protected $request_history_object;

    protected $auth_token = 'fake_de_token_for_de_testing';

    protected $subdomain = 'subdomain';

    public function setup()
    {
        $this->cj_client = new Client($this->auth_token, $this->subdomain);
        //setup history subscriber
        $this->cj_client->getEmitter()->attach($this->getHistoryObject());

    }

    /**
     * @return Mock mock responder queue object
     */
    protected function getMockObject()
    {
        if (!is_a($this->mock_response_object, 'GuzzleHttp\Subscriber\Mock')) {

            $this->mock_response_object = new Mock();

        }
        return $this->mock_response_object;
    }

    /**
     * @return History request history subscriber
     */
    protected function getHistoryObject()
    {
        if (!is_a($this->request_history_object, 'GuzzleHttp\Subscriber\History')) {

            $this->request_history_object = new History();

        }
        return $this->request_history_object;
    }

    /**
     * Adds a mock repsonse to the response queue
     *
     * @param \GuzzleHttp\Stream\Stream $data Stream data object
     * @param int $response_code desired response code
     */
    protected function addClientMock($data, $response_code = 200)
    {
        //create a response with the data and response code
        $api_response = new Response($response_code);
        $api_response->setBody($data);

        $mock_response = $this->getMockObject();
        $mock_response->addResponse($api_response);
    }

}