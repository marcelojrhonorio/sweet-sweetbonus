<?php

namespace App\Http\Controllers\Alfacon;

use DataTables;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SweetStaticApiTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class ResearchesController extends Controller
{
    use SweetStaticApiTrait;
    
    const ENDPOINT = '/leads';
    
    private $client;

    public function __construct() 
    {
        $this->client = new Client([
            'base_uri' => env('ALFACON_API_URL'),
            'headers' => [
                'x-api-key' => env('ALFACON_API_KEY'),
                'cache-control' => 'no-cache',
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        ]);
    }

    public function index(Request $request)
    {
        if (!env('ALFACON_RESEARCH')){
            return redirect('/');
        }

        return view('alfacon.research');
    }

    public function final(Request $request)
    {
        if (!env('ALFACON_RESEARCH')){
            return redirect('/');
        }

        return view('alfacon.final');
    }

    public function store(Request $request)
    {
        if (!env('ALFACON_RESEARCH')){
            return redirect('/');
        }

        /**
         * Get lead in session.
         */
        $fullname = $request->session()->get('fullname');
        $email    = $request->session()->get('email');
        $phone    = $request->session()->get('phone');
        $origin   = $request->session()->get('site_origin');

        $options = $request->all();
        $counter = 0;
        $redirect = '';
        $message = '';
        $research = ('' != $email) ? ($fullname . ' | ' . $email . ' | ' . $phone . ' | ' . $origin) : str_random('6');
        $c1 = '';
        $default = 'nao informado';

        foreach($options as $option)
        {
            /** ignore first param _token and aff_id */
            $counter += 1;
            if ($counter !== 1){

                if(is_array($option)){
                    
                    foreach($option as $option_checkbox){
                        
                        $option_checkbox = explode("-", $option_checkbox)[1];
                        $data = get_object_vars($this->getQuestion($option_checkbox));
                        $storedAnswer = $this->storeResearchAnswers(
                            $data['question_id'],
                            $research,
                            $option_checkbox);
                        $data['redirect_link'] === 'não informado' ?: $redirect = $data['redirect_link'];
                        $c1 = $data['redirect_message'];
                    }

                } else {

                    $option = explode("-", $option)[1];
                    $data = get_object_vars($this->getQuestion($option));
                    $storedAnswer = $this->storeResearchAnswers(
                        $data['question_id'], 
                        $research,                        
                        $option);
                    $data['redirect_link'] === 'não informado' ?: $redirect = $data['redirect_link'];
                    $c1 = $data['redirect_message'];
                }
            }
        }

        /**
         * Verify if lead is qualified.
         */
        if (1 === (int) ($data['redirect_message']) && '' != $email) {
            /**
             * Dispatch lead.
             */
            $response = self::sendAlfaconLead($fullname, $email, $phone, $this->client);

            /**
             * Store lead response.
             */
            self::saveLeadResponse($fullname, $email, $phone, $origin, $response);
        }

        /**
         * Delete session.
         */
        $request->session()->flush();

        /**
         * Redirect thanks page.
         */
        return redirect('/alfacon/final');
    }

    private function getQuestion($optionId)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/alfacon/v1/frontend/research-option/' . $optionId,
                []
            );

            return $response;

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        } catch (BadResponseException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    private function storeResearchAnswers (int $question, $research, int $option) 
    {
        try {

            $data = [
                'question_id' => $question,
                'option_id'   => $option,
                'research_id' => $research,
            ];
            
            $response = self::executeSweetApi(
                'POST',
                '/api/alfacon/v1/frontend/research-answer',
                $data
            );

            return $response;

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        } catch (BadResponseException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    /**
     * Send Alfacon Lead here.
     */
    private static function sendAlfaconLead($fullname, $email, $phone, $client) {
        try {

            $data = [
                'partner' => 'sweetmedia',
                'information' => [
                    'full_name' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                ],
            ];
    
            $response = $client->request('POST', self::ENDPOINT, [
                'headers' => [
                    'Content-Type'  => 'application/json',
                ],
                'json' => [$data],
            ]);

            return (200 === $response->getStatusCode() && "OK" === $response->getReasonPhrase()) ? 'success' : 'fail';

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        } catch (BadResponseException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    /**
     * Save lead response
     */
    private static function saveLeadResponse ($fullname, $email, $phone, $origin, $response) {
        try {
            
            $response = self::executeSweetApi(
                'POST',
                '/api/alfacon/v1/frontend/lead-response',
                [
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone, 
                    'site_origin' => $origin,
                    'response' => $response
                ]
            );

            return $response;

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        } catch (BadResponseException $exception) {
            Log::debug($exception->getMessage());
        }
    }

}
