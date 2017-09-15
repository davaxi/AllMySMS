<?php

namespace Davaxi\AllMySMS\Model;

use Davaxi\AllMySMS\Model;

/**
 * Class Email
 * @package Davaxi\AllMySMS\Model
 */
class Email extends Model
{
    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $contentHTML;

    /**
     * @var string
     */
    protected $contentText;

    /**
     * @var string
     */
    protected $campaignName;

    /**
     * @var string
     */
    protected $replyTo;

    /**
     * @param string $from
     * @param string $alias
     */
    public function setFrom($from, $alias = '')
    {
        $this->from = $from;
        if ($alias) {
            $this->setAlias($alias);
        }
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->checkDate($date);
        $this->date = date('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * @param string $content
     */
    public function setContentHtml($content)
    {
        $this->contentHTML = $content;
    }

    /**
     * @param string $content
     */
    public function setContentText($content)
    {
        $this->contentText = $content;
    }

    /**
     * @param string $campaignName
     */
    public function setCampaignName($campaignName)
    {
        $this->campaignName = $campaignName;
    }

    /**
     * @param string $replyTo
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'FROM' => $this->from,
            'TO' => $this->to,
            'SUBJECT' => $this->subject,
            'DATE' => $this->date,
            'HTML' => $this->contentHTML ? base64_encode($this->contentHTML) : null,
            'ALIAS' => $this->alias,
            'MAILTEXT' => $this->contentText,
            'CAMPAIGN_NAME' => $this->campaignName,
            'REPLY_TO' => $this->replyTo,
        ];
    }
}