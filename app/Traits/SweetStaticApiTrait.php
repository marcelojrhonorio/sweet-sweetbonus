<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Log;

trait SweetStaticApiTrait
{
    // getClient
    private static function getSweetClient(): \GuzzleHttp\Client
    {
        return new Client([
            'base_uri' => env('APP_SWEET_API'),
            'headers' => [
                    'Content-Type'  => 'application/json',
                    'cache-control' => 'no-cache',
                    'accept'        => 'application/json',
                ],
        ]);
    }

    private static function executeSweetApi(string $method = '', string $uri = '', $param = '')
    {
        $client = self::getSweetClient();
        
        if ('GET' === $method || 'get' === $method) {

            $response = $client->request($method, $uri, ['timeout' => 3.14], ['json'=>$param]);
            return self::getContentApi($response);

        } 

        $response = $client->request($method, $uri, ['json'=>$param]);
        return self::getContentApi($response);
        
    }

    private static function getContentApi($response = null)
    {
        return json_decode($response->getBody()->getContents());
    }
}
