<?php

namespace App\Http\Controllers\Ead;

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
        if (!env('EAD_RESEARCH')){
            return redirect('/');
        }

        $origin = $request->query('origin') ?? 'default';

        if ('sweet' === $origin) {
            session(['origin' => $origin]);
        }

        return view('ead.research');
    }

    public function final(Request $request)
    {
        if (!env('EAD_RESEARCH')){
            return redirect('/');
        }

        return view('ead.final');
    }

    public function store(Request $request)
    {
        if (!env('EAD_RESEARCH')){
            return redirect('/');
        }

        $session = $request->session();

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

        if ('sweet' === $request->session()->get('origin')) {
            $request->session()->flush();
            return redirect('/ead/final')->with(['redirect' => 'https://adzappy.go2cloud.org/aff_c?offer_id=80&aff_id=1048&file_id=1271']);
        }
        
        return redirect('/ead/final')->with(['redirect' => $redirect]);
    }

    private function getQuestion($optionId)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/ead/v1/frontend/research-option/' . $optionId,
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

            Log::debug($data);

            $response = self::executeSweetApi(
                'POST',
                '/api/ead/v1/frontend/research-answer',
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
