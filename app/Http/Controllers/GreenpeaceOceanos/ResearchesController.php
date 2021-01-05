<?php

namespace App\Http\Controllers\GreenpeaceOceanos;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
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

    public function index(Request $request)
    {
        if (!env('GREENPEACE_OCEANOS_RESEARCH')){
            return redirect('/');
        }

        return view('greenpeace-oceanos.research');
    }

    public function final(Request $request)
    {
        if (!env('GREENPEACE_OCEANOS_RESEARCH')){
            return redirect('/');
        }

        return view('greenpeace-oceanos.final');
    }

    public function store(Request $request)
    {
        if (!env('GREENPEACE_OCEANOS_RESEARCH')){
            return redirect('/');
        }

        $options = $request->all();
        $counter = 0;
        $redirect = '';
        $message = '';
        $research = str_random('6');
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

        if (1 === (int) $c1) {
            return redirect('https://store.sweetbonus.com.br');
        }

        return redirect('/pesquisa-oceanos/final')->with(['redirect' => $redirect]);
        
    }

    private function getQuestion($optionId)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/greenpeace-oceanos/v1/frontend/research-option/' . $optionId,
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
                '/api/greenpeace-oceanos/v1/frontend/research-answer',
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
}
