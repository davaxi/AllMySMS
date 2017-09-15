<?php

namespace Davaxi\AllMySMS\WebHook;

use Davaxi\AllMySMS\WebHook;

/**
 * Class InComing
 * @package Davaxi\AllMySMS\WebHook
 */
class InComing extends WebHook
{
    /**
     * Unique SMS id
     * @var string
     */
    protected $smsId;

    /**
     * Unique response SMS id
     * @var string
     */
    protected $smsMoId;

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
     * SMS Message
     * @var string
     */
    protected $message;

    /**
     * @param array $request
     * @return void
     */
    public function loadRequest(array $request)
    {
        $request = array_merge(
            [
                'smsId' => '',
                'smsMoId' => '',
                'receptionDate' => '',
                'phoneNumber' => '',
                'campaignId' => '',
                'message' => '',
            ],
            $request
        );
        $this->smsId = $request['smsId'];
        $this->smsMoId = $request['smsMoId'];
        $this->receptionDate = $request['receptionDate'];
        $this->phoneNumber = $request['phoneNumber'];
        $this->campaignId = $request['campaignId'];
        $this->message = $request['message'];
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
    public function getSMSMoId()
    {
        return $this->smsMoId;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
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