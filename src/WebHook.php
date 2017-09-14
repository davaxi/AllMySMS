<?php

namespace Davaxi\AllMySMS;

/**
 * Class WebHook
 * @package Davaxi\AllMySMS
 */
abstract class WebHook
{
    /**
     * Unique SMS id
     * @var string
     */
    protected $smsId;

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
                'receptionDate' => '',
                'phoneNumber' => '',
                'campaignId' => '',
            ],
            $request
        );
        $this->smsId = $request['smsId'];
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