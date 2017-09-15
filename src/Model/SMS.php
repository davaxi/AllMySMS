<?php

namespace Davaxi\AllMySMS\Model;

use Davaxi\AllMySMS\Model;

/**
 * Class SMS
 * @package Davaxi\AllMySMS\Model
 */
class SMS extends Model
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var bool
     */
    protected $flashMode = false;

    /**
     * @var array
     */
    protected $recipients = [];

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $campaign;

    /**
     * @var bool
     */
    protected $emailNotification = false;

    /**
     * @var string
     */
    protected $masterAccountLogin;

    /**
     * Set sender (default by provider is 36180)
     * Warning: For France recipients, only message with 'STOP au 36180'
     * allowed personalized sender
     * @param string $sender
     */
    public function setSender($sender)
    {
        $this->checkSender($sender);
        $this->sender = $sender;
    }

    /**
     * Set campaign name
     * @param string $campaign
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Set date to send SMS
     * @param string $date
     */
    public function setDate($date)
    {
        $this->checkDate($date);
        $this->date = date('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * Set ID for SMS (for Ack)
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Add recipient number with merge params
     * @param string $recipient
     * @param array $recipientParams
     */
    public function addRecipient($recipient, array $recipientParams = [])
    {
        $this->checkRecipient($recipient);
        $this->checkRecipientParams($recipientParams);
        $this->recipients[] = [
            'number' => $recipient,
            'params' => $recipientParams,
        ];
    }

    /**
     * Display message directly on screen phone and not saved on phone
     */
    public function activeFlashMode()
    {
        $this->flashMode = true;
    }

    /**
     * Active email notification
     */
    public function activeEmailNotification()
    {
        $this->emailNotification = true;
    }

    /**
     * Set master account login (for attachment)
     * @param string $masterAccountLogin
     */
    public function setMasterAccountLogin($masterAccountLogin)
    {
        $this->masterAccountLogin = $masterAccountLogin;
    }

    /**
     * Set message of SMS
     * @param $message
     */
    public function setMessage($message)
    {
        $this->checkMessage($message);
        $this->message = $message;
    }

    /**
     * @return integer
     */
    public function getLength()
    {
        return $this->getLengthFromMessage($this->message);
    }

    /**
     * @return integer
     */
    public function getMessageLength()
    {
        return $this->getMessageLengthFromMessage($this->message);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender,
            'date' => $this->date,
            'flashMode' => $this->flashMode,
            'recipients' => $this->recipients,
            'message' => $this->message,
            'paramsLength' => $this->getMessageParamsLength($this->message),
            'campaign' => $this->campaign,
            'emailNotification' => $this->emailNotification,
            'masterAccountLogin' => $this->masterAccountLogin,
        ];
    }

}