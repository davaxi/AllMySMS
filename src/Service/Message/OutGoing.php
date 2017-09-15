<?php

namespace Davaxi\AllMySMS\Service\Message;

use Davaxi\AllMySMS\Model\Email;
use Davaxi\AllMySMS\Model\MMS;
use Davaxi\AllMySMS\Model\SMS;
use Davaxi\AllMySMS\Service\Message;

/**
 * Class OutGoing
 * @package Davaxi\AllMySMS\Service\Message
 */
class OutGoing extends Message
{
    /**
     * Example response
     * {
     *      "status": 100,
     *      "statusText": "Your messages have been sent",
     *      "invalidNumbers": "",
     *      "campaignId": "xxxxxxxx",
     *      "credits": "340"
     * }
     *
     * @param SMS $sms
     * @return array
     */
    public function simpleSMS(SMS $sms)
    {
        $data = $sms->getData();
        $this->checkSimpleSMSData($data);

        $recipientsNumbers = array_map(
            function(array $recipient) {
                return $recipient['number'];
            },
            $data['recipients']
        );

        return $this->client->request('/', [
            'message' => $data['message'],
            'mobile' => implode(';', $recipientsNumbers),
            'tpoa' => $data['sender'],
            'date' => $data['date'],
            'flash' => $data['flashMode'] ? '1' : '0',
            'campaign' => $data['campaign'],
        ]);
    }

    /**
     * Example response:
     * {
     *      "status": 100,
     *      "statusText": "Your messages have been sent",
     *      "invalidNumbers": "",
     *      "campaignId": "xxxxxxxxxxx",
     *      "credits": "340",
     *      "creditsUsed": "15",
     *      "nbContacts": "1",
     *      "nbSms":"1",
     *      "smsIds":[
     *          {
     *              "phoneNumber":"336XXXXXXXX",
     *              "smsId":"330792bd-8e0b-11e5-bf51-0025907cd72e"
     *          }
     *      ]
     * }
     *
     * @param SMS $sms
     * @return array
     */
    public function SMS(SMS $sms)
    {
        return $this->sendSMS($sms, false);
    }

    /**
     * Example response:
     * {
     *      "status": 100,
     *      "statusText": "Your messages have been sent",
     *      "invalidNumbers": "",
     *      "nbCredits": 45,
     *      "nbContacts": 2,
     *      "nbSms": 3
     * }
     *
     * @param SMS $sms
     * @return array
     */
    public function simulateSMS(SMS $sms)
    {
        return $this->sendSMS($sms, false);
    }

    /**
     * Example response:
     * {
     *      "status": 100,
     *      "statusText": "Your messages have been sent",
     *      "invalidNumbers": "",
     *      "campaignId": "xxxxxxxxxxx",
     *      "credits": "340",
     *      "creditsUsed": "15",
     *      "nbContacts": "1",
     *      "nbSms":"1",
     *      "smsIds":[
     *          {
     *              "phoneNumber":"336XXXXXXXX",
     *              "smsId":"330792bd-8e0b-11e5-bf51-0025907cd72e"
     *          }
     *      ]
     * }
     *
     * @param MMS $mms
     * @return array
     */
    public function MMS(MMS $mms)
    {
        $data = $mms->getData();
        $this->checkMMSData($data);

        $recipientsData = array_map(
            function(array $recipient) {
                return [
                    'MOBILEPHONE' => $recipient['number'],
                ];
            },
            $data['recipients']
        );

        return $this->client->request('/', [
            'mmsData' => json_encode(
                [
                    'DATA' => [
                        'MESSAGE' => $data['message'],
                        'CAMPAIGN_NAME' => $data['campaign'],
                        'DATE' => $data['date'],
                        'MAIL_NOTIF' => $data['emailNotification'] ? '1' : '0',
                        'MMS' => $recipientsData,
                        'MSGCLASS' => $this->getMMSClassFromType($data['type']),
                        'IMAGE' => $data['imageUrl'],
                        'VIDEO' => $data['videoUrl'],
                        'SOUND' => $data['soundUrl'],
                        'CLIMSGID' => $data['id'],
                    ]
                ]
            )
        ]);
    }

    public function Email(Email $email)
    {
        $data = $email->getData();
        $this->checkEmailData($data);

        return $this->client->request('/sendEmail/', [
            'emailData' => json_encode(
                [
                    'DATA' => $data
                ]
            )
        ]);
    }

    /**
     * @param $type
     * @return int
     */
    protected function getMMSClassFromType($type)
    {
        if ($type === 'text') {
            return 0;
        }
        if ($type === 'image') {
            return 1;
        }
        if ($type === 'video') {
            return 2;
        }
        return 3;
    }

    /**
     * @param SMS $sms
     * @param $simulate
     * @return array
     */
    protected function sendSMS(SMS $sms, $simulate)
    {
        $data = $sms->getData();
        $this->checkSMSData($data);

        $recipientsData = array_map(
            function(array $recipient) {
                return array_merge(
                    [
                        'MOBILEPHONE' => $recipient['number'],
                    ],
                    $recipient['params']
                );
            },
            $data['recipients']
        );

        return $this->client->request(
            $simulate ? '/simulateCampaign/' : '/sendSMS/', [
            'smsData' => json_encode(
                [
                    'DATA' => [
                        'MESSAGE' => $data['message'],
                        'DYNAMIC' => $data['paramsLength'],
                        'FLASH' => $data['flashMode'] ? '1' : '0',
                        'CAMPAIGN_NAME' => $data['campaign'],
                        'DATE' => $data['date'],
                        'TPOA' => $data['sender'],
                        'MAIL_NOTIF' => $data['emailNotification'] ? '1' : '0',
                        'SMS' => $recipientsData,
                        'CLIMSGID' => $data['id'],
                        'MASTERACCOUNT' => $data['masterAccountLogin']
                    ]
                ]
            )
        ]);
    }

    /**
     * @param array $data
     */
    protected function checkSMSData(array $data)
    {
        if (!$data['recipients']) {
            throw new \LogicException('No recipients defined');
        }
        if (!$data['message']) {
            throw new \LogicException('No message defined');
        }
        foreach ($data['recipients'] as $recipient) {
            if (count($recipient['params']) !== $data['paramsLength']) {
                throw new \InvalidArgumentException('Expected ' . $data['paramsLength'] . ' params for recipient ' . $recipient['number']);
            }
        }
    }

    /**
     * @param array $data
     */
    protected function checkMMSData(array $data)
    {
        if (!$data['recipients']) {
            throw new \LogicException('No recipients defined');
        }
        if (!$data['type']) {
            throw new \LogicException('No mms type defined');
        }
    }

    /**
     * @param array $data
     */
    protected function checkSimpleSMSData(array $data)
    {
        if (!$data['recipients']) {
            throw new \LogicException('No recipients defined');
        }
        if (!$data['message']) {
            throw new \LogicException('No message defined');
        }
    }

    /**
     * @param array $data
     */
    protected function checkEmailData(array $data)
    {
        if (!$data['FROM']) {
            throw new \LogicException('No FROM defined');
        }
        if (!$data['TO']) {
            throw new \LogicException('No TO defined');
        }
        if (!$data['SUBJECT']) {
            throw new \LogicException('No SUBJECT defined');
        }
        if (!$data['HTML']) {
            throw new \LogicException('No HTML defined');
        }
    }
}