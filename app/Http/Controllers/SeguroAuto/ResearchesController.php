<?php

namespace App\Http\Controllers\SeguroAuto;

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
    
    public function index()
    {
        return view('seguro-auto.research.index');
    }

    public function store(Request $request)
    {
        $options = $request->all();
        $counter = 0;
        $redirect = '';
        $message = '';
        $request->session()->has('id') ? $research = (string) $request->session()->get('id') : $research = str_random('6');

        foreach($options as $option)
        {
            /** ignore first param (_token) */
            $counter += 1;
            if ($counter !== 1){

                if(is_array($option)){
                    
                    foreach($option as $option_checkbox){
                        
                        $option_checkbox = explode("-", $option_checkbox)[1];
                        $data = $this->getQuestion($option_checkbox);
                        $storedAnswer = $this->storeResearchAnswers(
                            $data->question_id,
                            $research,
                            $option_checkbox);
                        $data->redirect_link === 'não informado' ?: $redirect = $data->redirect_link;

                    }

                } else {

                    $option = explode("-", $option)[1];
                    $data = $this->getQuestion($option);
                    $storedAnswer = $this->storeResearchAnswers(
                        $data->question_id, 
                        $research,                        
                        $option);
                    $data->redirect_link === 'não informado' ?: $redirect = $data->redirect_link;

                }
            }            
        }
        
        return redirect('/seguro-auto/step-three/');
    }

    private function getQuestion ($optionId) 
    {
        try {

            $response = self::executeSweetApi(
                'GET',
                '/api/seguroauto/v1/frontend/research-option/' . $optionId,
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
                '/api/seguroauto/v1/frontend/research-answer',
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
