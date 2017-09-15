<?php

namespace Davaxi\AllMySMS\Service;

use Davaxi\AllMySMS\Service;

/**
 * Class ContactList
 * @package Davaxi\AllMySMS\Service
 */
class ContactList extends Service
{
    /**
     * Create contact list
     * Example of response:
     * {
     *      "status": "1",
     *      "statusText": "database successfully populated"
     * }
     *
     * @param $listName
     * @param array $fields
     * @param bool $locked
     * @param null $subAccount
     * @return array
     */
    public function createList($listName, array $fields, $locked = false, $subAccount = null)
    {
        if (!$listName) {
            throw new \InvalidArgumentException('Empty list name is not authorized');
        }
        $expectedField = [
            'FIELDNAME' => '',
            'FILTER' => 0,
            'MAILING' => 0,
        ];
        $structure = [];
        foreach ($fields as $field) {
            $field = array_merge($expectedField, $field);
            $field = array_intersect_key($field, $expectedField);
            if (!$field['FIELDNAME']) {
                throw new \InvalidArgumentException('Missing FIELDNAME');
            }
            $structure[] = $field;
        }
        return $this->client->request('/createList/', [
            'listData' => json_encode([
                'DATA' => [
                    'LISTNAME' => $listName,
                    'SUBACCOUNT' => $subAccount,
                    'LOCKED' => $locked ? '1' : '0',
                    'STRUCTURE' => $structure,
                ]
            ])
        ]);
    }

    /**
     * Get lists
     * Example response:
     * {
     *      "lists": [
     *          {
     *              "listName": "base name",
     *              "contacts": "120",
     *              "locked": "1",
     *              "creationDate": "2015-01-25"
     *          },
     *          {
     *              "listName": "base name",
     *              "contacts": "2",
     *              "locked": "0",
     *              "creationDate": "2015-02-05"
     *          }
     *      ]
     * }
     *
     * @param null $subAccount
     * @return array
     */
    public function getLists($subAccount = null)
    {
        return $this->client->request('/getLists/', [
            'subAccount' => $subAccount,
            'returnformat' => 'json',
        ]);
    }

    /**
     * Get contact from list
     * Example response:
     * {
     *      "contacts": [
     *          {
     *              "MobilePhone": "336xxxxxxxx ",
     *              "Firstname": "Michel",
     *              "Lastname": "Dupont",
     *              "Shop": "allmysms"
     *          },
     *          ...
     *      ]
     * }
     *
     * @param $listName
     * @param null $subAccount
     * @return array
     */
    public function getContacts($listName, $subAccount = null)
    {
        return $this->client->request('/getContacts/', [
            'listName' => $listName,
            'subAccount' => $subAccount,
            'returnformat' => 'json',
        ]);
    }

    /**
     * Delete list
     * Example result :
     * {
     *      "status": "1",
     *      "statusText": "list your base has been successfully deleted"
     * }
     *
     * @param $listName
     * @param null $subAccount
     * @return array
     */
    public function deleteList($listName, $subAccount = null)
    {
        if (!$listName) {
            throw new \InvalidArgumentException('Empty list name is not authorized');
        }
        return $this->client->request('/deleteList/', [
            'listName' => $listName,
            'subAccount' => $subAccount,
            'returnformat' => 'json',
        ]);
    }

    /**
     * Insert contacts in list
     * Example of result:
     * {
     *      "status": "1",
     *      "statusText": "list your base successfully populated",
     *      "success": 1,
     *      "ignored": 3,
     *      "duplicated": 2
     *  }
     *
     * @param $listName
     * @param array $contacts
     * @param null $subAccount
     * @return array
     */
    public function insertContacts($listName, array $contacts, $subAccount = null)
    {
        if (!$listName) {
            throw new \InvalidArgumentException('Empty list name is not authorized');
        }
        foreach ($contacts as $contact) {
            if (!isset($contact['MOBILEPHONE']) || !$contact['MOBILEPHONE']) {
                throw new \InvalidArgumentException('Missing MOBILEPHONE field');
            }
        }
        return $this->client->request('/createList/', [
            'populateData' => json_encode([
                'DATA' => [
                    'LISTNAME' => $listName,
                    'SUBACCOUNT' => $subAccount,
                    'CONTACTS' => $contacts,
                ],
            ]),
        ]);
    }

    /**
     * Delete contacts from list
     * Example of result:
     * {
     *      "status": "1",
     *      "statusText": "list your base successfully populated",
     *      "success": 1,
     *      "ignored": 3,
     *      "duplicated": 2
     *  }
     *
     * @param $listName
     * @param array $contacts
     * @param null $subAccount
     * @return array
     */
    public function deleteContacts($listName, array $contacts, $subAccount = null)
    {
        if (!$listName) {
            throw new \InvalidArgumentException('Empty list name is not authorized');
        }
        foreach ($contacts as $contact) {
            if (!isset($contact['MOBILEPHONE']) || !$contact['MOBILEPHONE']) {
                throw new \InvalidArgumentException('Missing MOBILEPHONE field');
            }
        }
        return $this->client->request('/createList/', [
            'deleteData' => json_encode([
                'DATA' => [
                    'LISTNAME' => $listName,
                    'SUBACCOUNT' => $subAccount,
                    'CONTACTS' => $contacts,
                ],
            ]),
        ]);
    }
}