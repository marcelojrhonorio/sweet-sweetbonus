<?php

namespace App\Http\Controllers\SeguroAuto;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use App\Traits\DddTrait;
use Illuminate\Http\Request;
use App\Traits\SweetStaticApiTrait;
use App\Events\CustomerCreatedEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class InsuranceInfoController extends Controller
{
    use DddTrait;
    use SweetStaticApiTrait;

    public function index(Request $request)
    {
        return view('seguro-auto.info.info');
    }

    public function postback(Request $request)
    {
        try{
            $customerId = $request->query('customer_id');

            
            if(empty($customerId)){
                return redirect('/seguro-auto/info');
            }

            $data = self::executeSweetApi(
                'POST',
                '/api/v1/frontend/customers/' . $customerId,
                []
            );
    
            $convertedDate = date("d-m-Y", strtotime($data->customer->birthdate));

            $request->session()->put([
                'id'        => $data->customer->id,
                'fullname'  => $data->customer->fullname,
                'cep'       => $data->customer->cep,
                'gender'    => $data->customer->gender,
                'birthdate' => $convertedDate,
                'email'     => $data->customer->email,
                'state'     => $data->customer->state,
            ]);             

            $destinationPage = $this->verifyCustomerSteps($customerId, $request);

            switch($destinationPage){
                case 'step_two':
                    return redirect('/seguro-auto/step-two');
                    break;

                case 'influence_research':
                    return redirect('/seguro-auto/research');
                    break;

                case 'step_three':
                    return redirect('/seguro-auto/step-three');
                    break;

                case 'finished':
                    return redirect('/seguro-auto/final');
                    break;                    
            }          

            return redirect('/seguro-auto/info')->with('customer', [
                'id'        => $data->customer->id,
                'fullname'  => $data->customer->fullname,
                'cep'       => $data->customer->cep,
                'gender'    => $data->customer->gender,
                'birthdate' => $convertedDate,
                'email'     => $data->customer->email,
            ]);

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

    public function store(Request $request)
    {
        /**
         * Validators
         */
        $birthDateValidation = Validator::make($request->only('birthdate'), [
            'birthdate' => 'required|date_format:d/m/Y',
        ]);

        if ($birthDateValidation->fails()) {
            return response()->json([
                'status' => 'invalid_birthdate',
                'data'   => [],
            ]);
        }

        $birthdate = self::formatBirthdate($request->birthdate);

        $birth = new \DateTime($birthdate);
        $today = new \DateTime();
        $diff  = $birth->diff($today);

        if ($diff->y > 100 || $diff->y <= 16) {
            return response()->json([
                'status' => 'invalid_birthdate',
                'data'   => [],
            ]);
        }

        if ((!isset($request->customer_id)) && 
            (!is_null($request->phone_number)) &&
            (null === $this->verifyDdd($request->phone_number))) { 
            return response()->json([
                'status' => 'invalid_ddd',
                'data'   => $request->phone_number,
            ]);
        }
        
        $birthDateValidation = Validator::make($request->all(), [
            'birthdate' => 'required|date_format:d/m/Y',
        ]);

        if ($birthDateValidation->fails()) {
            return response()->json([
                'status' => 'invalid_birthdate',
                'data'   => $birthDateValidation->errors(),
            ]);
        }

        $cepValidation = Validator::make($request->all(), [
            'cep' => 'required|string|size:10',
        ]);

        if ($cepValidation->fails()) {
            return response()->json([
                'status' => 'invalid_cep',
                'data'   => $cepValidation->errors(),
            ]);
        }

        /**
         * End Validators.
         */

        $params   = self::getParams($request);
        //$customer = (!isset($request->customer_id)) ? self::createCustomer($params) : self::updateCustomer($params);
        
        if (!isset($request->customer_id)) {
            $customer = self::createCustomer($params);

            if (isset($customer->status) && ('email_exists' === $customer->status)) {
                return response()->json([
                    'status' => 'email_exists',
                    'data'   => $customer->result,
                ]);
            }

            $request->session()->put([
                'id'        => $customer->result->id,
                'fullname'  => $customer->result->fullname,
                'cep'       => $customer->result->cep,
                'gender'    => $customer->result->gender,
                'birthdate' => $customer->result->birthdate,
                'email'     => $customer->result->email,
            ]);

            return response()->json([
                'status' => 'success',
                'data'   => $customer->result,
            ]);

        } else {

            $customer = self::getCustomer($request->customer_id);

            if (true === $customer->success) {
    
                $request->session()->put([
                    'id'        => $customer->customer->id,
                    'fullname'  => $customer->customer->fullname,
                    'cep'       => $customer->customer->cep,
                    'gender'    => $customer->customer->gender,
                    'birthdate' => $customer->customer->birthdate,
                    'email'     => $customer->customer->email,
                ]);
    
                return response()->json([
                    'status' => 'success',
                    'data'   => $customer->customer,
                ]);            
            }
        }
    }

    private static function getCustomer(int $id)
    {
        $response = self::executeSweetApi(
            'POST',
            '/api/v1/frontend/customers/' . $id,
            []
        );

        return $response;
    }

    private function verifyCustomerSteps($id, $request)
    {
        try{

            $research = self::executeSweetApi(
                'GET',
                '/api/seguroauto/v1/frontend/customer-researches?where[customer_id]=' . $id,
                []
            );        

            if (empty($research->data)){
                return 'step_one';
            }          

            if ('0' === $research->data[0]->has_car){
                return 'finished';                
            }
          
            $customerResearchAnswer = self::executeSweetApi(
                'GET',
                '/api/seguroauto/v1/frontend/customer-research-answers?[customer_research_id]' . $research->data[0]->id,
                []
            );

            if (empty($customerResearchAnswer->data)){
                $request->session()->put('customerResearchId', $research->data[0]->id);
                return 'step_two';
            }            

            $researchAnswer = self::executeSweetApi(
                'GET',
                '/api/seguroauto/v1/frontend/research-answer?where[research_id]=' . (string) $id,
                []
            );               
            
            if (empty($researchAnswer->data) && '0' === $customerResearchAnswer->data[0]->customer_research_answer_has_insurance){
                return 'influence_research';
            }              

            if ('0' === $research->data[0]->completed){
                return 'step_three';
            }

            return 'finished';

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


    private static function createCustomer ($params) {
        try {
            $response = self::executeSweetApi(
                'POST',
                '/api/v1/frontend/customers',
                $params
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

    private static function updateCustomer ($params) {
        $customer = self::getCustomer($params['id']);
        
        $customer->fullname = $params['fullname'];
        $customer->gender   = $params['gender'];
        $customer->cep      = $params['cep'];

        try {
            $response = self::executeSweetApi(
                'PUT',
                '/api/v1/frontend/customers/' . (int) $params['id'],
                $customer
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

    private static function getParams ($request) {
        if (isset($request->customer_id)) {
            return [
                'id'        => $request->customer_id,
                'fullname'  => $request->fullname,
                'gender'    => $request->gender,
                'cep'       => $request->cep,
            ];
        }

        return [
            'fullname'  => $request->fullname,
            'gender'    => $request->gender,
            'ddd'       => (int) $request->phone_number,
            'cep'       => $request->cep,
            'birthdate' => self::formatBirthdate($request->birthdate),
            'email'     => $request->email,
        ];
    }

    private static function formatBirthdate ($birthdate) {
        $birthdate = explode('/', $birthdate);
        $birthdate = array_reverse($birthdate);
        $birthdate = implode('-', $birthdate);

        return $birthdate;
    }

}
