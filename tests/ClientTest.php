<?php

use Davaxi\AllMySMS\Client as Client;

/**
 * Class ClientMockup
 */
class ClientMockup extends Client
{
    /**
     * @param $attribute
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        return $this->$attribute;
    }

    /**
     * @param $method
     * @return mixed
     */
    public function callProtectedMethod($method)
    {
        return $this->$method();
    }
}

class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ClientMockup
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = new ClientMockup();
    }

    public function testConstructEmpty()
    {
        $this->client = new ClientMockup();

        $login = $this->client->getAttribute('login');
        $this->assertEmpty($login);

        $apiKey = $this->client->getAttribute('apiKey');
        $this->assertEmpty($apiKey);
    }

    public function testConstructEmptyApiKey()
    {
        $this->client = new ClientMockup('MyLogin');

        $login = $this->client->getAttribute('login');
        $this->assertEquals('MyLogin', $login);

        $apiKey = $this->client->getAttribute('apiKey');
        $this->assertEmpty($apiKey);
    }

    public function testConstructEmptyLogin()
    {
        $this->client = new ClientMockup(null, 'MyApiKey');

        $login = $this->client->getAttribute('login');
        $this->assertEmpty($login);

        $apiKey = $this->client->getAttribute('apiKey');
        $this->assertEquals('MyApiKey', $apiKey);
    }

    public function testConstruct()
    {
        $this->client = new ClientMockup('MyLogin', 'MyApiKey');

        $login = $this->client->getAttribute('login');
        $this->assertEquals('MyLogin', $login);

        $apiKey = $this->client->getAttribute('apiKey');
        $this->assertEquals('MyApiKey', $apiKey);
    }

    public function testSetLogin()
    {
        $login = $this->client->getAttribute('login');
        $this->assertEmpty($login);

        $this->client->setLogin('MyLogin');
        $login = $this->client->getAttribute('login');
        $this->assertEquals('MyLogin', $login);
    }

    public function testSetApiKey()
    {
        $apiKey = $this->client->getAttribute('apiKey');
        $this->assertEmpty($apiKey);

        $this->client->setApiKey('MyApiKey');
        $apiKey = $this->client->getAttribute('apiKey');
        $this->assertEquals('MyApiKey', $apiKey);
    }

    public function testGetUrl()
    {
        $url = $this->client->getUrl('/myPath/');
        $this->assertEquals('https://api.allmysms.com/http/9.0/myPath/', $url);
    }

    public function testGetBaseUrl()
    {
        $baseUrl = $this->client->callProtectedMethod('getBaseUrl');
        $this->assertEquals('https://api.allmysms.com/http/9.0', $baseUrl);
    }

    /**
     * @expectedException \LogicException
     */
    public function testCheckBeforeRequest_NoLoginNoApiKey()
    {
        $this->client->callProtectedMethod('checkBeforeRequest');
    }

    /**
     * @expectedException \LogicException
     */
    public function testCheckBeforeRequest_NoApiKey()
    {
        $this->client->setLogin('MyLogin');
        $this->client->callProtectedMethod('checkBeforeRequest');
    }

    /**
     * @expectedException \LogicException
     */
    public function testCheckBeforeRequest_NoLogin()
    {
        $this->client->setApiKey('MyApiKey');
        $this->client->callProtectedMethod('checkBeforeRequest');
    }

    public function testCheckBeforeRequest()
    {
        $this->client->setLogin('MyLogin');
        $this->client->setApiKey('MyApiKey');
        $this->client->callProtectedMethod('checkBeforeRequest');
        $this->assertTrue(true);
    }
}