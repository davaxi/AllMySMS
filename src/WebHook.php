<?php

namespace Davaxi\AllMySMS;

/**
 * Class WebHook
 * @package Davaxi\AllMySMS
 */
abstract class WebHook
{
    /**
     * @param array $request
     * @return void
     */
    abstract function loadRequest(array $request);
}