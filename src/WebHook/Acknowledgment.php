<?php

namespace Davaxi\AllMySMS\WebHook;

use Davaxi\AllMySMS\WebHook;

/**
 * Class Acknowledgment
 * @package Davaxi\AllMySMS\WebHook
 */
class Acknowledgment extends WebHook
{
    const STATUS_CODES = [
        '1' => 'Issued',
        '2' => 'Not delivered (sent by Operator)',
        '3' => 'Transmitted to operator',
        '4' => 'Message rejected',
        '5' => 'SMS rejected (probably unknown number / absent subscriber)',
    ];

    /**
     * SMS status code
     * @var string
     */
    protected $status;

    /**
     * SMS status message
     * @var string
     */
    protected $statusText;

    /**
     * @param array $request
     * @return void
     */
    public function loadRequest(array $request)
    {
        $request = array_merge(
            [
                'status' => '',
                'statusText' => '',
            ],
            $request
        );
        $this->status = $request['status'];
        $this->statusText = $request['statusText'];
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusText;
    }
}