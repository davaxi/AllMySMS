<?php

namespace Davaxi\AllMySMS\Model;

use Davaxi\AllMySMS\Model;

/**
 * Class MMS
 * @package Davaxi\AllMySMS\Model
 */
class MMS extends Model
{
    /**
     * @var string
     */
    protected $mmsId;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $date;

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
     * @var string
     */
    protected $pictureUrl;

    /**
     * @var string
     */
    protected $videoUrl;

    /**
     * @var string
     */
    protected $soundUrl;

    /**
     * @var bool
     */
    protected $emailNotification = false;

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
     * @param string $mmsId
     */
    public function setMMSId($mmsId)
    {
        $this->mmsId = $mmsId;
    }

    /**
     * Specify MMS is text
     */
    public function hasText()
    {
        if ($this->type) {
            throw new \LogicException('You can\'t have multiple MMS resource');
        }
        $this->type = 'text';
    }

    /**
     * Specify MMS is picture
     */
    public function hasImage()
    {
        if ($this->type) {
            throw new \LogicException('You can\'t have multiple MMS resource');
        }
        $this->type = 'image';
    }

    /**
     * Specify MMS is video
     */
    public function hasVideo()
    {
        if ($this->type) {
            throw new \LogicException('You can\'t have multiple MMS resource');
        }
        $this->type = 'video';
    }

    /**
     * Specify MMS is sound
     */
    public function hasSound()
    {
        if ($this->type) {
            throw new \LogicException('You can\'t have multiple MMS resource');
        }
        $this->type = 'sound';
    }

    /**
     * @param string $url
     */
    public function setPictureUrl($url)
    {
        $this->hasImage();
        $this->checkPictureUrl($url);
        $this->pictureUrl = $url;
    }

    /**
     * @param string $url
     */
    public function setVideoUrl($url)
    {
        $this->hasVideo();
        $this->checkVideoUrl($url);
        $this->videoUrl = $url;
    }

    /**
     * @param string $url
     */
    public function setSoundUrl($url)
    {
        $this->hasSound();
        $this->checkSoundUrl($url);
        $this->soundUrl = $url;
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
     * Active email notification
     */
    public function activeEmailNotification()
    {
        $this->emailNotification = true;
    }

    /**
     * Set message of SMS (if > 160 char => type Text)
     * @param $message
     */
    public function setMessage($message)
    {
        $this->checkMessage($message);
        $this->message = $message;
        if ($this->getLength() > 1) {
            $this->hasText();
        }
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
            'id' => $this->mmsId,
            'date' => $this->date,
            'recipients' => $this->recipients,
            'message' => $this->message,
            'paramsLength' => $this->getMessageParamsLength($this->message),
            'campaign' => $this->campaign,
            'emailNotification' => $this->emailNotification,
            'type' => $this->type,
            'pictureUrl' => $this->pictureUrl,
            'videoUrl' => $this->videoUrl,
            'soundUrl' => $this->soundUrl,
        ];
    }

}