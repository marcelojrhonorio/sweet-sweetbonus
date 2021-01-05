<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TokenController;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ClientErrorResponseException;

class TokenController extends Controller
{
    const ENDPOINT_TOKEN = 'api/v1/customers/token/renew';  

    public static function renew($client, $customerId){        
    
        $response = $client->post(self::ENDPOINT_TOKEN . '/' . 
            session()->get('idCustomer'), [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'cache-control' => 'no-cache',
                    'accept' => 'application/json',
                ]
            ]);
            
        $content = $response->getBody()->getContents();

        $data = \GuzzleHttp\json_decode($content);

        if ($data->data !== session()->get('token'))
        {
            session()->put('token', $data->data);
        }

        return $data->data;
    }
}
