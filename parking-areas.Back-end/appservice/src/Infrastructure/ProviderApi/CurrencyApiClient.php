<?php

namespace App\Infrastructure\ProviderApi;

use App\Infrastructure\Services\ProviderInterface;
use DateTime;
use Exception;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
//use GuzzleHttp\Utils;

class CurrencyApiClient implements ProviderInterface
{
    const API_URI_EXCHANGE = 'http://api.exchangeratesapi.io/v1/latest';
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $criteria
     * @return array|bool|float|int|object|string|null
     * @throws Exception
     * @throws TransportExceptionInterface
     * @throws DecodingExceptionInterface
     */
    public function getContent(array $criteria): float|object|int|bool|array|string|null
    {
        $response = "";
        $accessKey = '?access_key=35cae90d4f8c251fcc3b1d1bf9ed4016';

        if (!$criteria)
        {
            //$date = new DateTime();
            $response = $this->client->request(
                'GET',
                self::API_URI_EXCHANGE. $accessKey
            );
        }

        return $response->toArray();
        //  return Utils::jsonDecode($response->getBody()->getContents(), true);
    }
}
