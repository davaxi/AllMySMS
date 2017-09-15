<?php

namespace Davaxi\AllMySMS;

/**
 * Class Service
 * @package Davaxi\AllMySMS
 */
abstract class Service
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Service constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


}