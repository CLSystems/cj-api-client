<?php

namespace CLSystems\Tests\CommissionJunction;

use CLSystems\CommissionJunction\Client as Client;
use CLSystems\Tests\ClientTestCase;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Stream\Stream;

class ClientTest extends ClientTestCase
{

    public function setup()
    {
        parent::setup();

    }

    public function testClientIsGuzzleClient()
    {
        $this->assertTrue(is_a($this->cj_client, 'GuzzleHttp\Client'));
    }

    public function testBaseUrlIsSetCorrectly()
    {
        $this->cj_client = new Client($this->auth_token, 'somesubdomain');

        $baseUrl = $this->cj_client->getBaseUrl();

        $this->assertEquals('https://somesubdomain.api.cj.com/v3/', $baseUrl);
    }

    public function testExceptionIsThrownOnErrorResponse()
    {

        $this->addClientMock(new Stream(fopen(RESOURCE_PATH . '/commission-detail-response.xml', 'r')), 500);

        $this->cj_client->getEmitter()->attach($this->getMockObject());

        try {
            $this->cj_client->get('/');
        } catch ( ServerException $expected ) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }


    public function testExceptionIsThrownOnBadRequestResponse()
    {

        $this->addClientMock(new Stream(fopen(RESOURCE_PATH . '/commission-detail-response.xml', 'r')), 400);

        $this->cj_client->getEmitter()->attach($this->getMockObject());

        try {
            $this->cj_client->get('/');
        } catch ( ClientException $expected ) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }


}
