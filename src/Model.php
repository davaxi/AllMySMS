<?php

namespace Davaxi\AllMySMS;

/**
 * Class Model
 * @package Davaxi\AllMySMS
 */
abstract class Model
{
    /**
     * Minimum length for sender
     */
    const SENDER_MIN_LENGTH = 3;

    /**
     * Maximum length for sender
     */
    const SENDER_MAX_LENGTH = 11;

    /**
     * If message < 160 chars => 1 SMS
     */
    const MESSAGE_MAX_LENGTH = 160;

    /**
     * If message > 160 chars => 153 chars / SMS (7 chars for combining UDH)
     */
    const MESSAGES_INDIVIDUAL_LENGTH = 153;

    /**
     * Not allowed message with > 1224 chars (8 x 153)
     */
    const MESSAGES_MAX_LENGTH = 1224;

    /**
     * Allowed MMS Picture extensions
     */
    const ALLOWED_PICTURE_EXTENSIONS = ['.jpg', '.png', '.gif'];

    /**
     * Allowed MMS Video extensions
     */
    const ALLOWED_VIDEO_EXTENSIONS = ['.3gp'];

    /**
     * Allowed MMS Sound extensions
     */
    const ALLOWED_SOUND_EXTENSIONS = ['.amr', '.mid'];

    /**
     * @param $sender
     */
    protected function checkSender($sender)
    {
        $senderLength = strlen($sender);
        if ($senderLength > static::SENDER_MAX_LENGTH) {
            throw new \InvalidArgumentException('Invalid sender. Max allowed ' . static::SENDER_MAX_LENGTH . ' chars.');
        }
        if ($senderLength < static::SENDER_MIN_LENGTH) {
            throw new \InvalidArgumentException('Invalid sender. Min allowed ' . static::SENDER_MIN_LENGTH . ' chars.');
        }
        if (preg_match('/[^a-zA-Z0-9\ ]/', $sender)) {
            throw new \InvalidArgumentException('Invalid sender. Only allowed a-z / A-Z / 0-9');
        }
        if (!preg_match('/^[a-zA-Z]/', $sender)) {
            throw new \InvalidArgumentException('Invalid sender. Necessary start with a-z / A-Z');
        }
    }

    /**
     * @param string $date
     */
    protected function checkDate($date)
    {
        $epoch = strtotime($date);
        if (!$epoch) {
            throw new \InvalidArgumentException('Invalid date. Allowed format YYYY-MM-DD HH:ii:ss or relative');
        }
    }

    /**
     * @param string $recipient
     */
    protected function checkRecipient($recipient)
    {
        // For french numbers
        if (preg_match('/^0[1-9][0-9]{8}$/', $recipient)) {
            return;
        }
        if (!preg_match('/^(00|\+)[0-9]{3,}$/', $recipient)) {
            throw new \InvalidArgumentException('Invalid recipient number : ' . $recipient . '. Only international format started with 00 or +. Or french number');
        }
    }

    /**
     * @param array $params
     */
    protected function checkRecipientParams(array $params)
    {
        $index = 0;
        ksort($params);
        foreach ($params as $key => $value) {
            $expectedKey = 'PARAMS_' . $index;
            if ($key !== $expectedKey) {
                throw new \InvalidArgumentException('Invalid params key ' . $key . '. Expected key : ' . $expectedKey);
            }
            if (!is_string($value)) {
                throw new \InvalidArgumentException('Invalid params value for key ' . $key . '. Expected string value');
            }
        }
    }

    /**
     * @param string $message
     */
    protected function checkMessage($message)
    {
        $messageLength = $this->getMessageLengthFromMessage($message);
        if ($messageLength > static::MESSAGES_MAX_LENGTH) {
            throw new \InvalidArgumentException('Message is to long. Allow only ' . static::MESSAGES_MAX_LENGTH . ' chars. Current message have ' . $messageLength . ' chars');
        }
    }

    /**
     * @param string $message
     * @return integer
     */
    protected function getLengthFromMessage($message)
    {
        $messageLength = $this->getMessageLengthFromMessage($message);
        if ($messageLength <= static::MESSAGE_MAX_LENGTH) {
            return 1;
        }
        return ceil($messageLength / static::MESSAGES_INDIVIDUAL_LENGTH);
    }

    /**
     * @param $message
     * @return integer
     */
    protected function getMessageLengthFromMessage($message)
    {
        // Remove marker
        $message = preg_replace('/#param\_[0-9]+#/', '', $message);
        return strlen($message);
    }

    /**
     * @param string $message
     * @return int
     */
    protected function getMessageParamsLength($message)
    {
        return preg_match_all('/#param_[0-9]+#/', $message);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getExtension($path)
    {
        return strtolower(strrchr($path, '.'));
    }

    /**
     * @param string $url
     */
    protected function checkSoundUrl($url)
    {
        $extension = $this->getExtension($url);
        if (!in_array($extension, static::ALLOWED_SOUND_EXTENSIONS, true)) {
            throw new \InvalidArgumentException('Invalid sound path. Allowed only : ' . implode(', ', static::ALLOWED_SOUND_EXTENSIONS));
        }
    }

    /**
     * @param string $url
     */
    protected function checkVideoUrl($url)
    {
        $extension = $this->getExtension($url);
        if (!in_array($extension, static::ALLOWED_VIDEO_EXTENSIONS, true)) {
            throw new \InvalidArgumentException('Invalid videp path. Allowed only : ' . implode(', ', static::ALLOWED_VIDEO_EXTENSIONS));
        }
    }

    /**
     * @param string $url
     */
    protected function checkPictureUrl($url)
    {
        $extension = $this->getExtension($url);
        if (!in_array($extension, static::ALLOWED_PICTURE_EXTENSIONS, true)) {
            throw new \InvalidArgumentException('Invalid picture path. Allowed only : ' . implode(', ', static::ALLOWED_PICTURE_EXTENSIONS));
        }
    }
}