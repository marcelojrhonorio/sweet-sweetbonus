<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\TokenController;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ClientErrorResponseException;
//use GuzzleHttp\Exception\GuzzleException;
//GuzzleHttp\Exception\GuzzleException

class CampaignAnswersController extends Controller
{

    const ENDPOINT = '/api/v1/frontend/campaigns/answers';

    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('APP_SWEET_API'),
            'headers' => [
                'cache-control' => 'no-cache',
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        ]);
    }

    public function save(Request $request)
    {
        TokenController::renew($this->client, session()->get('token'));

        $response = $this->client->post(self::ENDPOINT, [
            'headers' => [
                'app-token' => 'Bearer ' .  session()->get('token'),
                'Content-Type' => 'application/json',
                'cache-control' => 'no-cache',
                'accept' => 'application/json',
            ],
            'json' => [
                'answer' => $request->get('answer'),
                'campaign' => $request->get('campaign'),
                'customer' => $request->session()->get('customer'),
            ]
        ]);

        return $response->getBody()->getContents();
    }

}
