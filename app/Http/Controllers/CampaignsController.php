<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Traits\SweetStaticApiTrait;
use App\Traits\ReplaceAutofillLink;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class CampaignsController extends Controller
{
    const ENDPOINT = '/api/v1/frontend/campaigns';
    const ENDPOINT_ANSWERS = '/api/v1/frontend/campaigns';

    private $client;

    use SweetStaticApiTrait;
    use ReplaceAutofillLink;

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

    public function index() {

       return view('campaigns.index')->with(
        'smartlook', self::verifySmartlook());
    }

    public function indexNewCampaigns () {
        return view('layouts.new-campaigns');
    }


    private static function verifySmartlook(){

        try {
            
            $response = self::executeSweetApi(
                'GET',
                '/api/v1/frontend/services-enabled-time/smartlook',
                []
            );
        
            return $response->data;
            
        } catch (ClientException $e) {
            $content = [];
            
            Log::debug("Client expection, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Client expection, response ->".Psr7\str($e->getResponse()));
            }
            
            preg_match('/{.*}/i', $e->getMessage(), $content);

            Log::debug(print_r($content, true));
        
            return response()->json([
                'status' => $e->getCode(),
                'errors' => \GuzzleHttp\json_decode($content[0], true)['modelError'],
            ], 422);                 
        }
        catch (RequestException $e) 
        {            
            Log::debug("Request Expection , request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Request Expection ->".Psr7\str($e->getResponse()));
            }
        } 
        catch (ConnectException $e) 
        {
            Log::debug("Connection expection, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Connection expection, response ->".Psr7\str($e->getResponse()));
            }
        } 

        catch (BadResponseException $e) 
        {
            Log::debug("Bad Response, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Bad Response, response ->".Psr7\str($e->getResponse()));
            }
        } 
    }

    public function search(Request $request)
    {
        TokenController::renew($this->client, session()->get('token'));

        $customer = Customer::find(session()->get('idCustomer'));

        if (is_null($customer->campaign_started_at)) {
            $customer->campaign_started_at = Carbon::now()->toDateTimeString();
            $customer->save();
        }

        $response = $this->client->get(self::ENDPOINT . '/filtered', [
            'headers' => [
                'app-token' => 'Bearer ' .  session()->get('token'),
                'Content-Type' => 'application/json',
                'cache-control' => 'no-cache',
                'accept' => 'application/json',
            ],
            'json' => [
                'data' => [
                    'domainName' => env('APP_NAME'),
                    'mobile' => 1,
                    'desktop' => 1,
                    'idCustomer' => session()->get('idCustomer'),
                    'gender' => session()->get('gender'),
                    'phone' => session()->get('phone_number'),
                    'cep' => session()->get('cep'),
                    'birthdate' => session()->get('birthdate'),
                ]
            ]
        ]);

        $campaigns = json_decode($response->getBody()->getContents());

        foreach ($campaigns->results as $result) {
            if ('Autofill' === $result->types->type) {
                $result->clickout[0]->link =
                    self::handleReplaceLink($result->clickout[0]->link);
            }
        }

        return json_encode($campaigns);
    }

    public function save(Request $request)
    {
        TokenController::renew($this->client, session()->get('token'));

        $response = $this->client->patch(self::ENDPOINT . '/' . $request->get('id'), [
            'headers' => [
                'app-token' => 'Bearer ' .  session()->get('token'),
                'Content-Type' => 'application/json',
                'cache-control' => 'no-cache',
                'accept' => 'application/json',
            ]
        ]);

        return $response->getBody()->getContents();
    }

    public function comingFromStore ($customerId)
    {
        $customer = Customer::find($customerId) ?? null;

        if (null === $customer) {
            return redirect(env('STORE_URL'));
        }

        self::setCurrentUser($customer);

        $customer->campaign_answers_at = Carbon::now()->toDateTimeString();
        $customer->save();

        return redirect('/campaigns');

    }

    public function comingFromDashboard($campaign_id)
    {
        $campaign = self::getCampaign($campaign_id);

        return view('campaigns.preview')->with(
            'campaign', $campaign);
    }

    private static function getCampaign($campaign_id)
    {
        try {

            $response = self::executeSweetApi(
                'GET',
                '/api/v1/frontend/campaing-from-dashboard/'.$campaign_id,
                []
            );
            
            return $response;

        } catch (ClientException $e) {
            $content = [];
            
            Log::debug("Client expection, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Client expection, response ->".Psr7\str($e->getResponse()));
            }
            
            preg_match('/{.*}/i', $e->getMessage(), $content);

            Log::debug(print_r($content, true));
        
            return response()->json([
                'status' => $e->getCode(),
                'errors' => \GuzzleHttp\json_decode($content[0], true)['modelError'],
            ], 422);                 
        }
        catch (RequestException $e) 
        {            
            Log::debug("Request Expection , request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Request Expection ->".Psr7\str($e->getResponse()));
            }
        } 
        catch (ConnectException $e) 
        {
            Log::debug("Connection expection, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Connection expection, response ->".Psr7\str($e->getResponse()));
            }
        } 

        catch (BadResponseException $e) 
        {
            Log::debug("Bad Response, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Bad Response, response ->".Psr7\str($e->getResponse()));
            }
        } 
    }

    private static function setCurrentUser ($customer) 
    {
        session()->put([
            'customer'     => $customer,
            'idCustomer'   => $customer->id,
            'token'        => $customer->token,
            'email'        => $customer->email,
            'birthdate'    => $customer->birthdate,
            'phone_number' => $customer->ddd ?? '',
            'gender'       => $customer->gender,
            'cep'          => $customer->cep,
       ]);        
    }

}
