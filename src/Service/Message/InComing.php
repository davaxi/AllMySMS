<?php

namespace Davaxi\AllMySMS\Service\Message;

use Davaxi\AllMySMS\Service\Message;

/**
 * Class InComing
 * @package Davaxi\AllMySMS\Service\Message
 */
class InComing extends Message
{
    /**
     * Get last response after last call API
     * Example response:
     * {
     *     "mos": [
     *         {
     *             "phoneNumber": "336xxxxxxxx",
     *             "id": "32154",
     *             "campaignId": "ap_28423xxxxx",
     *             "message": "Réponse 1",
     *             "receptionDate": "2014-02-14 15:09:05"
     *         },
     *         {
     *             "phoneNumber": "336xxxxxxxx",
     *             "id": "32157",
     *             "campaignId": "ap_28423xxxxx",
     *             "message": "Réponse 1",
     *             "receptionDate": "2014-02-14 15:25:48"
     *         }
     *     ]
     * }
     *
     * @param int $limit
     * @param null $subAccount
     * @return array
     */
    public function getLastReceivedSMS($limit = 1000, $subAccount = null)
    {
        return $this->client->request('/getPulls/', [
            'limit' => $limit,
            'subAccount' => $subAccount,
            'returnformat' => 'json'
        ]);
    }

    /**
     * Get responses from sent campaign SMS
     * Example response:
     * {
     *     "mos": [
     *         {
     *             "phoneNumber": "336xxxxxxxx",
     *             "id": "32154",
     *             "campaignId": "ap_28423xxxxx",
     *             "message": "Réponse 1",
     *             "receptionDate": "2014-02-14 15:09:05"
     *         },
     *         {
     *             "phoneNumber": "336xxxxxxxx",
     *             "id": "32157",
     *             "campaignId": "ap_28423xxxxx",
     *             "message": "Réponse 1",
     *             "receptionDate": "2014-02-14 15:25:48"
     *         }
     *     ]
     * }
     *
     * @param int $campaignId CampaignId of send SMS
     * @param null $subAccount
     * @return array
     */
    public function getReceivedSMS($campaignId, $subAccount = null)
    {
        return $this->client->request('/getPull/', [
            'campId' => $campaignId,
            'subAccount' => $subAccount,
            'returnformat' => 'json'
        ]);
    }

    /**
     * Get response from sent SMS
     * Example response:
     * {
     *     "phoneNumber": "336xxxxxxxx",
     *     "campaignId": "ap_28423xxxxx",
     *     "message": "Réponse 1",
     *     "receptionDate": "2014-02-14 15:09:05"
     * }
     *
     * @param string $smsId (returned smsId from sendSMS / sendSimpleSMS responses)
     * @param null $subAccount
     * @return array
     */
    public function getResponse($smsId, $subAccount = null)
    {
        return $this->client->request('/getPullBySmsId/', [
            'smsId' => $smsId,
            'subAccount' => $subAccount,
            'returnformat' => 'json'
        ]);
    }
}