<?php

namespace Davaxi\AllMySMS\Service;

use Davaxi\AllMySMS\Service;

/**
 * Class Tools
 * @package Davaxi\AllMySMS\Service
 */
class Tools extends Service
{
    /**
     * Get cost for send SMS to country Number (ISO format ex: FR / DE / ...)
     * Example response:
     * {
     *      "isoCode": "FR",
     *      "nbCredits": "15"
     * }
     *
     * @param $countryIsoCode
     * @return array
     */
    public function getSMSCostForCountry($countryIsoCode)
    {
        return $this->client->request('/getCreditsByCountryIsoCode/', [
            'countryIsoCode' => $countryIsoCode
        ]);
    }

    /**
     * Shorten URL
     * Example response:
     * {
     *      "url": "http:\/\/www.yoururl.fr",
     *      "shortUrl": "http:\/\/bs.ms\/xxxx"
     * }
     *
     * @param $url
     * @return array
     */
    public function shortenUrl($url)
    {
        return $this->client->request('/shortenUrl/', [
            'url' => $url,
            'returnformat' => 'json'
        ]);
    }
}