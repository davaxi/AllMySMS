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
     * Unique response SMS id
     * @var string
     */
    protected $smsMoId;

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
        parent::loadRequest($request);
        $request = array_merge(
            [
                'smsMoId' => '',
                'message' => '',
            ],
            $request
        );
        $this->smsMoId = $request['smsMoId'];
        $this->message = $request['message'];
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

}