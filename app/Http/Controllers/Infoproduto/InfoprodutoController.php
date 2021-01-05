<?php

namespace App\Http\Controllers\Infoproduto;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Traits\SweetStaticApiTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class InfoprodutoController extends Controller
{
    use SweetStaticApiTrait;
    
    public function postback($customerId) {

        $customer = self::getCustomer($customerId);

        if (!isset($customer)) {
            $customerId = str_random('6');
        }

        return redirect('/profile-research/research')->with('customerId', $customerId);
    }

    public function showResearch() {
        return view('infoproduto.research')
            ->with(
                [
                    'customerId' => session('customerId'),
                    'research'   => self::getResearch(),
                ]);
    }

    public function saveResearch(Request $request) {
        $data = $request->all();

        foreach ($data['data'] as $register) {
            self::storeResearchAnswers($register);
        }

        self::saveIncentiveEmail($data['data'][0]['research_id']);

        return response()->json([
            'status' => 'success',
            'data'   => $request->all(),
        ]);
    }

    private static function getCustomer($customerId) {
        try {

            $response = self::executeSweetApi(
                'POST',
                '/api/v1/frontend/customers/' . $customerId,
                []
            );
    
            return $response->customer ?? null;
            
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

    private static function getResearch() {
        try {

            $response = self::executeSweetApi(
                'GET',
                '/api/infoproduto/v1/frontend/research-question',
                []
            );
    
            return $response->data ?? null;            

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

    private function storeResearchAnswers ($register) 
    {
        try {

            $data = [
                'question_id'   => $register['question_id'],
                'option_id'     => $register['option_id'],
                'research_id'   => (string) $register['research_id'],
                'answer_string' => (string) $register['answer_string']
            ];

            $response = self::executeSweetApi(
                'POST',
                '/api/infoproduto/v1/frontend/research-answer',
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

    private static function saveIncentiveEmail(int $customerId) {

        try {

            $data = [
                'incentive_emails_id'   => env('INFOPRODUTO_INCENTIVE_EMAIL_ID'),
                'customers_id'          => $customerId,
                'points'                => 15,
            ];
    
    
            $response = self::executeSweetApi(
                'POST',
                '/api/incentive/v1/frontend/checkin',
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
