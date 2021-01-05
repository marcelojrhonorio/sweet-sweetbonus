<?php

namespace App\Http\Controllers\Carsystem;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SweetStaticApiTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class ResearchesController extends Controller
{
    use SweetStaticApiTrait;

    public function index(Request $request)
    {
        if (!env('CARSYSTEM_RESEARCH')){
            return redirect('/');
        }

        return view('carsystem.research');
    }

    public function final(Request $request)
    {
        if (!env('CARSYSTEM_RESEARCH')){
            return redirect('/');
        }

        return view('carsystem.final');
    }

    public function iDowntWant1(Request $request)
    {
        if (!env('CARSYSTEM_RESEARCH')){
            return redirect('/');
        }

        return view('carsystem.dont-want-1');
    }  
    
    public function iDowntWant2(Request $request)
    {
        if (!env('CARSYSTEM_RESEARCH')){
            return redirect('/');
        }

        return view('carsystem.dont-want-2');
    }    

    public function store(Request $request)
    {
        if (!env('CARSYSTEM_RESEARCH')){
            return redirect('/');
        }

        $options = $request->all();
        $counter = 0;
        $redirect = '';
        $message = '';
        $research = str_random('6');
        
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
                        $data['redirect_link']     === 'não informado' ?: $redirect = $data['redirect_link'];
                        $data['redirect_message']  === 'não informado' ?: $message  = $data['redirect_message'];

                    }

                } else {

                    $option = explode("-", $option)[1];
                    $data = get_object_vars($this->getQuestion($option));
                    $storedAnswer = $this->storeResearchAnswers(
                        $data['question_id'], 
                        $research,                        
                        $option);
                    $data['redirect_link']     === 'não informado' ?: $redirect = $data['redirect_link'];
                    $data['redirect_message']  === 'não informado' ?: $message  = $data['redirect_message'];

                }
            }
        }
        if($message == 1){
            return redirect('/carsystem/nao-gostaria1')->with(['redirect' => $redirect]);
        } else if($message == 2) {
            return redirect('/carsystem/nao-gostaria2')->with(['redirect' => $redirect]);        
        } else {
            return redirect('/carsystem/final')->with(['redirect' => $redirect]);
        }

    }

    private function getQuestion($optionId)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/carsystem/v1/frontend/research-option/' . $optionId,
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

    private function storeResearchAnswers ($question, $research, $option) 
    {
        try {

            $data = [
                'question_id' => $question,
                'option_id'   => $option,
                'research_id' => $research,
            ];

            $response = self::executeSweetApi(
                'POST',
                '/api/carsystem/v1/frontend/research-answer',
                $data
            );

            return $response;

        } catch (ClientException $e) {
            $content = [];

            preg_match('/{.*}/i', $e->getMessage(), $content);

            return response()->json([
                'status' => $e->getCode(),
                'errors' => \GuzzleHttp\json_decode($content[0], true)['modelError'],
            ], 422);
        }
    }  

}
