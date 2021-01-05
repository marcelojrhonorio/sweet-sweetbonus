<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientErrorResponseException;

/**
 * @todo Add docs.
 */
class ClairvoyantController extends Controller
{

    const ENDPOINT      =   '/api/v1/frontend/clairvoyant';
    const ENDPOINT_LIST =   '/api/v1/frontend/clairvoyant/list';
    
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

    public function create(Request $req){

        try {

            $params = [
                'name'            =>  $req->input('first_name'),
                'email'           =>  $req->input('email_address'),
                'birthdate'       =>  $req->input('birthdate'),
                'gender'          =>  $req->input('gender'),
            ];
    
            $firstname = explode(' ', $params['name'])[0];
            
            $leadUrl = 'http://p.guardianangelreading.com/aff_c?offer_id=350&aff_id=1619&firstname='. $firstname .'&email=' . $params['email'] . '&birthdate=' . $params['birthdate'] . '&gender=' . $params['gender'] . '&timezone=0&aff_sub=SWEET';
            
            $birthDateValidation = Validator::make($req->only('birthdate'), [
                'birthdate' => 'required|date_format:Y/m/d',
            ]);            
            
            if ($birthDateValidation->fails()) {
                return response()->json([
                    'status' => 'invalid_birthdate',
                    'data'   => $birthDateValidation->errors(),
                ]);
            }
                        
            $birth = new \DateTime($req->input('birthdate'));
            $today = new \DateTime();
            $diff  = $birth->diff($today);
            
            if ($diff->y > 100 || $diff->y <= 16) {
                return response()->json([
                    'status' => 'invalid_birthdate',
                    'data'   => [],
                ]);
            }

            if ($diff->y >= 36) {
                $clientLead = new Client();
                $response = $clientLead->get($leadUrl);
                $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
            }

            if(!isset($data)) {
    
                $lead = "Não";
                $pixel = "Não";

            } else {
                
                $lead = "Sim";
    
                $transactionsId                 =   [];
                $transactionsId['hasoffers']    =   session('hasoffersToken');
                $transactionsId['company']      =   session('hasoffersToken');
                
    
                $clientCompany = new Client();
                $clientHasoffers = new Client();
    
                $response = $clientCompany
                    ->get('http://ad.bdstracking.com/SP4Dx?transaction_id='.$transactionsId['company']);
                $response = $clientCompany
                    ->get('http://springmedia.go2cloud.org/aff_lsr?offer_id=2786&transaction_id='.$transactionsId['company']);
                // $response = $clientHasoffers
                //     ->get('http://sweet.go2cloud.org/aff_lsr?offer_id=70&transaction_id='.$transactionsId['hasoffers']);
                
                $response = $response->getBody()->getContents();
                
                if ($response == 'success=true;'){
                    $pixel = "Sim";
                } else {
                    $pixel = "Não";
                }
            }
    
            $gender = ('male' === $req->input('gender')) ? 'M' : 'F';

            $data = [
                'first_name'    =>   $req->input('first_name'),
                'email_address' =>   $req->input('email_address'),
                'birthdate'     =>   $req->input('birthdate'),
                'gender'        =>   $gender,
                'ddd_home'      =>   $req->input('ddd_home'),
                'phone_home'    =>   $req->input('phone_home'),
                'lead'          =>   $lead,
                'pixel'         =>   $pixel, 
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

    public function getTrackingId(Request $request){

        $data = $request->query('session_id');
        $request->session()->put('hasoffersToken', $data);
        
        if($request->query('session_id2')){
            $data = $request->query('session_id2');
            $request->session()->put('companyToken', $data);
        }

        return redirect('/clairvoyant');
    }

    public function cadastros(Request $request){
        $response = $this->client->get(self::ENDPOINT_LIST, [
            'headers' => [
                'Content-Type' => 'application/json',
                'cache-control' => 'no-cache',
                'accept' => 'application/json',
            ]
        ]);

        $cadastros = \GuzzleHttp\json_decode($response->getBody()->getContents())->results;

        return view('clairvoyant.cadastros', compact('cadastros'));      
    }

    public function index(Request $request)
    {
        return view('clairvoyant.index');
    }
}
