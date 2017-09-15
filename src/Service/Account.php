<?php

namespace Davaxi\AllMySMS\Service;

use Davaxi\AllMySMS\Service;

/**
 * Class Account
 * @package Davaxi\AllMySMS\Service
 */
class Account extends Service
{
    /**
     * Get info from account (or subAccount)
     * Example of response:
     * {
     *      "status": "Active Account",
     *      "credits": "1847"
     *      "apiKey": "vikmakey",
     *      "lastName": "Dupont",
     *      "firstName": "Marc",
     *      "society": "allmysms.com",
     *      "email": "support@allmysms.com"
     *  }
     *
     * @param string $subAccount
     * @return array
     */
    public function getInfo($subAccount = null)
    {
        return $this->client->request('/getInfo/', [
            'subAccount' => $subAccount,
            'returnformat' => 'json'
        ]);
    }

    /**
     * Get blacklisted numbers
     * Example of response :
     * {
     *      "blacklist": [
     *          {
     *              "phoneNumber": "336XXXXXXXX",
     *              "comment": "stop", // or Refused / manual unsubscribe
     *              "receptionDate": "2014-02-18 12:10:23"
     *          }
     *      ]
     * }
     *
     * @param null $subAccount
     * @return array
     */
    public function getBlacklist($subAccount = null)
    {
        return $this->client->request('/getBlacklist/', [
            'subAccount' => $subAccount,
            'returnformat' => 'json'
        ]);
    }

    /**
     * Example response:
     * {
     *      'status': 'OK'
     * }
     *
     * @param $campaignId
     * @return array
     */
    public function deleteProgrammedCampaign($campaignId)
    {
        return $this->client->request('/deleteCampaign/', [
            'campId' => $campaignId,
            'returnformat' => 'json'
        ]);
    }

    /**
     * Create subAccount
     * Example response:
     * {
     *      "status": "1",
     *      "text": "Sub-account successfully created"
     * }
     *
     * @param array $data
     * @return array
     */
    public function createSubAccount(array $data)
    {
        $expectedData = array_merge(
            $this->getDefaultSubAccountData(),
            [
                'SENDEMAILTOCUSTOMER' => '0',
                'SENDEMAILTOMASTERACCOUNT' => '0',
                'POSTPAID' => '0',
                'PROFILE' => '',
            ]
        );
        $data = array_merge($expectedData, $data);
        $data = array_intersect_key($data, $expectedData);
        $this->checkSubAccountData($data);
        return $this->client->request('/createSubAccount/', [
            'accountData' => json_encode([
                'DATA' => $data,
            ]),
        ]);
    }

    /**
     * Update SubAccount
     * Example response:
     * {
     *      "status": "1",
     *      "text": "Sub-account successfully updated"
     * }
     *
     * @param $subAccount
     * @param array $data
     * @return array
     */
    public function updateSubAccount($subAccount, array $data)
    {
        $expectedData = $this->getDefaultSubAccountData();
        $data = array_merge($expectedData, $data);
        $data = array_intersect_key($data, $expectedData);
        $this->checkSubAccountData($data);
        return $this->client->request('/updateSubAccount/', [
            'subAccount' => $subAccount,
            'accountData' => json_encode([
                'DATA' => $data,
            ]),
        ]);
    }

    /**
     * Get subAccounts
     * {
     *      "total": 15,
     *      "subAccounts": [
     *          {
     *              "Login": "subaccountx",
     *              "LastName": "Doe",
     *              "FirstName": "John",
     *              "ClientType": "Company",
     *              "Company": "My Company",
     *              "Phone": "33xxxxxxxxx",
     *              "Mobile": "33xxxxxxxxx ",
     *              "Fax": "",
     *              "Email": "subaccountx@msinnovations.com",
     *              "Address": "1240 route des dolines",
     *              "Zip": "06560",
     *              "City": "valbonne",
     *              "Country": "France",
     *              "CreationDate": "2014-01-01 10:30:00",
     *              "LastVisit": "2014-05-20 14:30:00",
     *              "LastActivity": "2014-05-22 17:15:00",
     *              "BillLastName": "Doe",
     *              "BillFirstName": "John",
     *              "BillCompany": "My Company",
     *              "BillPhone": "33xxxxxxxxx ",
     *              "BillMobile": "33xxxxxxxxx ",
     *              "BillEmail": "subaccountx@msinnovations.com",
     *              "BillAddress": "1240 route des dolines",
     *              "BillZip": "06560",
     *              "BillCity": "valbonne",
     *              "BillCountry": "France",
     *              "Credits": "1500"
     *          },
     *          { ... }
     *      ]
     *  }
     *
     * @return array
     */
    public function getSubAccounts()
    {
        return $this->client->request('/getSubAccounts/', [
            'returnformat' => 'json',
        ]);
    }

    /**
     * Add or Remove credit (n or -n) on subAccount
     * Example of response:
     * {
     *      "subAccount": [
     *          {
     *              "Login": "subaccountx",
     *              "Credits": "1500"
     *          },
     *      ]
     * }
     *
     * @param $subAccount
     * @param $credit
     * @return array
     */
    public function manageSubAccountCredits($subAccount, $credit)
    {
        return $this->client->request('/manageSubAccountCredits/', [
            'subAccount' => $subAccount,
            'credits' => $credit,
            'returnformat' => 'json',
        ]);
    }

    /**
     * Delete subAccount
     * Example of response:
     * {
     *      "subAccount": [
     *          {
     *              "Login": "subaccountx",
     *              "Credits": "1500"
     *          },
     *      ]
     * }
     *
     * @param $subAccount
     * @return array
     */
    public function deleteSubAccount($subAccount)
    {
        return $this->client->request('/deleteSubAccount/', [
            'loginToDelete' => $subAccount,
            'returnformat' => 'json',
        ]);
    }

    /**
     * @return array
     */
    protected function getDefaultSubAccountData()
    {
        return [
            'FIRSTNAME' => '',
            'LASTNAME' => '',
            'SOCIETY' => '',
            'MOBILE' => '',
            'EMAIL' => '',
            'LOGIN' => '',
            'PASSWORD' => '',
            'PHONE' => '',
            'WEBSITE' => '',
            'ADDRESS' => '',
            'ZIP' => '',
            'CITY' => '',
            'COUNTRY' => '',
            'BILLFIRSTNAME' => '',
            'BILLLASTNAME' => '',
            'BILLSOCIETY' => '',
            'BILLADDRESS' => '',
            'BILLZIP' => '',
            'BILLCITY' => '',
            'BILLCOUNTRY' => '',
            'BILLEMAIL' => '',
            'BILLMOBILE' => '',
            'BILLPHONE' => '',
            'ACTIVE' => '0',
        ];
    }

    /**
     * @param array $data
     */
    protected function checkSubAccountData(array $data)
    {
        if (!$data['FIRSTNAME']) {
            throw new \InvalidArgumentException('Missing FIRSTNAME');
        }
        if (!$data['LASTNAME']) {
            throw new \InvalidArgumentException('Missing LASTNAME');
        }
        if (!$data['EMAIL']) {
            throw new \InvalidArgumentException('Missing EMAIL');
        }
        if (!$data['LOGIN']) {
            throw new \InvalidArgumentException('Missing LOGIN');
        }
        if (!$data['PASSWORD']) {
            throw new \InvalidArgumentException('Missing PASSWORD');
        }
        else if (strlen($data['PASSWORD']) < 6) {
            throw new \InvalidArgumentException('PASSWORD need min 6 char');
        }
    }
}