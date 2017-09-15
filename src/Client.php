<?php

namespace Davaxi\AllMySMS;

/**
 * Class Client
 * @package Davaxi\AllMySMS
 */
class Client
{
    /**
     * Base of API Url
     */
    const DOMAIN = 'https://api.allmysms.com/http';

    /**
     * Version of API
     */
    const VERSION = '9.0';

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * Client constructor.
     * @param null|string $login
     * @param null|string $apiKey
     */
    public function __construct($login = null, $apiKey = null)
    {
        if ($login) {
            $this->setLogin($login);
        }
        if ($apiKey) {
            $this->setApiKey($apiKey);
        }
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $path
     * @return string
     */
    public function getUrl($path)
    {
        return sprintf('%s%s', $this->getBaseUrl(), $path);
    }

    /**
     * @param $path
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function request($path, array $params)
    {
        $this->checkBeforeRequest();

        $params['login'] = $this->login;
        $params['apiKey'] = $this->apiKey;

        $path = $this->getUrl($path);
        try {
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $path);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        catch (\Exception $e) {
            throw new \Exception('Service unreachable or too long to answer. Exception: ' . $e->getMessage());
        }
        return json_decode($result, true);
    }

    protected function checkBeforeRequest()
    {
        if (!$this->login) {
            throw new \LogicException('No login defined in client');
        }
        if (!$this->apiKey) {
            throw new \LogicException('No apiKey defined in client');
        }
    }

    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        return sprintf('%s/%s',static::DOMAIN, static::VERSION);
    }

}