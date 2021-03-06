<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Traits\SweetStaticApiTrait;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

/**
 * @todo Add docs.
 */
class HomeController extends Controller
{
    /**
     * @todo Add docs.
     */

    use SweetStaticApiTrait;

    public function index(Request $request)
    {        
        $domain = preg_match("/(?:uat-sweetbonus)/", URL::current()) ? 'uat-sweetbonus' : 'sweetbonus';

        return view('index')->with([
                'domain'    =>  $domain,
                'page'      =>  'home',
                'smartlook' => self::verifySmartlook()
        ]);
    }

    
    public function indexFromShare(Request $request)
    {     
        $domain = preg_match("/(?:uat-sweetbonus)/", URL::current()) ? 'uat-sweetbonus' : 'sweetbonus';
       
        $data = [
            'comming_from'  => 4,
            'customer_id'   => $request->input('customer_id'),
            'customer_name' => $request->input('customer_name'),
            'action_id'     => $request->input('action_id'),
            'action_type'   => $request->input('action_type'),
        ];

        if(isset($data)) {
            return view('index')->with([
                'domain'    => $domain,
                'data'      => $data,
                'page'      => 'compartilhar',
                'smartlook' => self::verifySmartlook()
            ]);            
        }

        return view('index')->with([
                'domain'    =>  $domain,
                'page'      =>  'home',
                'smartlook' => self::verifySmartlook()
            ]);
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
}
