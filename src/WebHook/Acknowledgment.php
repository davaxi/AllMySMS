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
     * Unique SMS id
     * @var string
     */
    protected $smsId;

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
     * SMS date of accused operator
     * @var string
     */
    protected $receptionDate;

    /**
     * SMS phone number (in international format)
     * @var string
     */
    protected $phoneNumber;

    /**
     * SMS Campaign Id
     * @var string
     */
    protected $campaignId;

    /**
     * @param array $request
     * @return void
     */
    public function loadRequest(array $request)
    {
        $request = array_merge(
            [
                'smsId' => '',
                'status' => '',
                'statusText' => '',
                'receptionDate' => '',
                'phoneNumber' => '',
                'campaignId' => '',
            ],
            $request
        );
        $this->smsId = $request['smsId'];
        $this->status = $request['status'];
        $this->statusText = $request['statusText'];
        $this->receptionDate = $request['receptionDate'];
        $this->phoneNumber = $request['phoneNumber'];
        $this->campaignId = $request['campaignId'];
    }

    /**
     * @return string
     */
    public function getSMSId()
    {
        return $this->smsId;
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

    /**
     * @return string
     */
    public function getReceptionDate()
    {
        return $this->receptionDate;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }
}