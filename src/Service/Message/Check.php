<?php

namespace Davaxi\AllMySMS\Service\Message;

use Davaxi\AllMySMS\Service\Message;

/**
 * Class Check
 * @package Davaxi\AllMySMS\Service\Message
 */
class Check extends Message
{
    /**
     * Get Acknowledgment for specified campaign Id
     * Example response:
     * {
     *      "acks": [
     *          {
     *              "phoneNumber": "336xxxxxxxx",
     *              "statut": "1",
     *              "comment": "Delivered",
     *              "receptionDate": "2014-02-19 11:40:35"
     *          },
     *          {
     *              "phoneNumber": "336xxxxxxxx",
     *              "statut": "1",
     *              "comment": "Delivered",
     *              "receptionDate": "2014-02-19 11:40:36"
     *          }
     *      ],
     *      "cliMsgId": "xxxx"
     * }
     *
     * @param string $campaignId (returned campaignId from sendSMS / sendSimpleSMS responses)
     * @param null|string $subAccountLogin
     * @return array
     */
    public function getSMSAcknowledgments($campaignId, $subAccountLogin = null)
    {
        return $this->client->request('/getAcks/', [
            'campId' => $campaignId,
            'subAccount' => $subAccountLogin,
            'returnformat' => 'json'
        ]);
    }

    /**
     * Get Acknowledgment for specified sms Id
     * Example response:
     * {
     *      "phoneNumber": "336xxxxxxxx",
     *      "statut": "1",
     *      "comment": "Delivered",
     *      "receptionDate": "2014-02-19 11:40:35"
     *  }
     *
     * @param string $smsId (returned smsId from sendSMS / sendSimpleSMS responses)
     * @param null|string $subAccountLogin
     * @return array
     */
    public function getSMSAcknowledgment($smsId, $subAccountLogin = null)
    {
        return $this->client->request('/getAckBySmsId/', [
            'smsId' => $smsId,
            'subAccount' => $subAccountLogin,
            'returnformat' => 'json'
        ]);
    }

}