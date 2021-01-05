<?php

namespace App\Http\Controllers;

use DB;
use Log;
use DataTables;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientErrorResponseException;

class XMoveCarController extends Controller
{
    const ENDPOINT = '/api/v1/frontend/xmove-car';

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

    public function index(Request $request)
    {
        $domain = preg_match("/(?:uat-sweetbonus)/", URL::current()) ? 'uat-sweetbonus' : 'sweetbonus';

        return view('index')->with([
            'domain'    =>  $domain,
            'page'      =>  'xmove-car',
        ]);        
    }

    public function create(Request $request)
    {
        try {
            
            $data = [
                'name'       => $request->input('name'),
                'email'      => $request->input('email'),
                'cell_phone' => $request->input('cell_phone'),
                'phone'      => $request->input('phone') ?? 'Não informado',
            ]; 
    
            $response = $this->client->request('POST', self::ENDPOINT, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'cache-control' => 'no-cache',
                    'accept' => 'application/json',
                ],
                'json' => $data,
            ]);
    
            $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

            return \GuzzleHttp\json_encode($data);

          
        } catch (ClientException $e) {
            $content = [];
            
            Log::debug("Client expection, request ->".Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Client expection, response ->".Psr7\str($e->getResponse()));
            }

            Log::debug(Psr7\str($e->getResponse()));

            preg_match('/{.*}/i', $e->getMessage(), $content);

            Log::debug(print_r($content, true));

            if(preg_match("/(?:Email hash already exists)/", $e->getMessage()))
            {
                return response()->json([
                    'status'  => 'email_exists',
                    'data'    => [],
                ]);
            }

            if(preg_match("/(?:Email doesn't exist)/", $e->getMessage()))
            {
                return response()->json([
                    'status' => 'non_existent_email',
                    'data'   => [],
                ]); 
            }
           
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

    public function final()
    {
        return view('layouts.partials.xmove-car-final');
    }

    public function search()
    {       
        $results = DB::select("select * from sweet_xmovecar.xmove_cars;"); 

        return datatables()->of($results)->toJson();
    }

    public function show () 
    {
        return view('layouts.partials.xmove-car-results');
    }

}
