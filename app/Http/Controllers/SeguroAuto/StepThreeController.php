<?php

namespace App\Http\Controllers\SeguroAuto;

use Carbon\Carbon;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Events\CarInsuranceCreated;
use App\Traits\SweetStaticApiTrait; 
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class StepThreeController extends Controller
{
    use SweetStaticApiTrait;

    public function index(Request $request)
    {
        if($request->session()->has('id')){
            return view('seguro-auto.step03');
        }
        else {
            return redirect('/seguro-auto/info');
        }        
    }

    public function store(Request $request)
    {
        $inputs = $request->only(['cpf', 'mobile_phone', 'phone']);
        $rules = [
            'cpf'          => 'required|cpf',
            'mobile_phone' => 'required|celular_com_ddd',
        ];

        $validation = Validator::make($inputs, $rules);
        
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Celular e/ou CPF inválidos.',
                'errors' => $validation->errors(),
                'data' => [],
            ]);
        }
            
        $id = session('id');
            
        $customer = $this->getCustomer($id);
            
        if(empty($customer)){
            return response()->json([
            'success' => false,
            'message' => 'Customer não encontrado.',
            'data' => [],
            ]);            
        }
            
        $hasResearch = $this->getResearches();
            
        if ($hasResearch->total) {
            $research = $hasResearch->data[0];
            
            $researchData = [
                'completed' => 1,
                'customer_id' => session('id'),
                'customer_research_points' => 100,
            ];
            
            $updatedResearch = $this->updateResearch($research->id, $researchData);
        }
            
        $customer->cpf = preg_replace("/\D+/", "", $inputs['cpf']) ?? $customer->cpf; 
        $customer->points += 100;
        $numberWithDdd = preg_replace('/\D+/', '', $inputs['mobile_phone']) ?? $customer->phone_number;
        $customer->phone_number = substr($numberWithDdd, 2, 5) . '-' . substr($numberWithDdd, 7, 4);
        $customer->ddd = substr($numberWithDdd, 0, 2);
        $customer->secondary_phone_number = preg_replace('/\D+/', '', $inputs['phone']) ?? $customer->secondary_phone_number;

        $customerParams = get_object_vars($customer);
        $updatedCustomer = $this->updateCustomer($id, $customerParams);

        if ('duplicated_cpf' === $updatedCustomer->status) {
            return response()->json([
                'success' => false,
                'message' => 'CPF inválido!',
                'data'    => [],
            ]);    
        }
        
        if (100 >= $this->getTotalLeads() &&
            $this->verifyCustomerLead($customer->id) &&
            env('SEGURO_AUTO_LEAD_SEND')) {
            event(new CarInsuranceCreated($customer->id));
        }

        return response()->json([
            'success' => true,
            'message' => 'Dados atualizados com sucesso.',
            'data' => [
                'customer' => $customer,
                'updatedResearch' => $updatedResearch ?? null,
            ],
        ]);        

    }

    private function getCustomer($id)
    {
        $response = self::executeSweetApi(
            'POST',
            '/api/v1/frontend/customers/' . $id,
            []
        );

        return $response->customer;
    }

    private function getResearches()
    {
        $response = self::executeSweetApi(
            'GET',
            '/api/seguroauto/v1/frontend/customer-researches?where[customer_id]=' . session('id'),
            []
        );
    
        return $response;
    }

    private function updateResearch($researchId, array $data = [])
    {
        $response = self::executeSweetApi(
            'PUT',
            '/api/seguroauto/v1/frontend/customer-researches/' . $researchId,
            $data
        );
    
        return $response;        
    }    

    private function updateCustomer($customerId, array $data = [])
    {
        try {

            $response = self::executeSweetApi(
                'PUT',
                '/api/v1/frontend/customers/' . $customerId,
                $data
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
                'errors' => '',
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

    private function getTotalLeads()
    {
        $response = self::executeSweetApi(
            'GET',
            '/api/seguroauto/v1/frontend/veem-leads?where[creation_date]=' . Carbon::today()->toDateString() . '&where[lead_sicronized]=1&limit=51',
            []
        );
    
        return $response->total;         
    }    

    private function verifyCustomerLead($verifyCustomerLead = 0)
    {
        $response = self::executeSweetApi(
            'GET',
            "/api/seguroauto/v1/frontend/veem-leads?where[customer_id]={$verifyCustomerLead}",
            []
        );
    
        return $response->total;          
    }    

}