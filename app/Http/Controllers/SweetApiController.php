<?php

namespace App\Http\Controllers;

use Browser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Traits\DddTrait;
use Illuminate\Http\Request;
use App\Traits\FixMailDomain;
use App\Jobs\CustomerCreatedJob;
use Illuminate\Support\Facades\Log;
use App\Traits\SweetStaticApiTrait;
use App\Events\CustomerCreatedEvent;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MemberGetMember\UpdatePointsController;

class SweetApiController extends Controller
{
    use SweetStaticApiTrait;
    use FixMailDomain;
    use DddTrait;

    const ENDPOINT = '/api/v1/frontend/customers';

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

    public function create(Request $request)
    {
        try {
            $email = $this->fixMailDomain($request->input('email'));
            $email = $email ?? $request->input('email');

            $birthDateValidation = Validator::make($request->only('birthdate'), [
                'birthdate' => 'required|date_format:d/m/Y',
            ]);

            if ($birthDateValidation->fails()) {
                return response()->json([
                    'status' => 'invalid_birthdate',
                    'data'   => $birthDateValidation->errors(),
                ]);
            }

            $birthdate = $request->get('birthdate');
            $birthdate = explode('/', $birthdate);
            $birthdate = array_reverse($birthdate);
            $birthdate = implode('-', $birthdate);

            $birth = new \DateTime($birthdate);
            $today = new \DateTime();
            $diff  = $birth->diff($today);

            if ($diff->y > 100 || $diff->y <= 16) {
                return response()->json([
                    'status' => 'invalid_birthdate',
                    'data'   => [],
                ]);
            }

            $cepValidation = Validator::make($request->only('cep'), [
                'cep' => 'required|string|size:10',
            ]);

            if ($cepValidation->fails()) {
                return response()->json([
                    'status' => 'invalid_cep',
                    'data'   => $cepValidation->errors(),
                ]);
            }

            $cleanCep = preg_replace("/\D+/", "", $request->only('cep'));

            $data = self::callPricezApi($cleanCep);
            
            if (isset($data->payload->ddd)) {

                $ddd   = $data->payload->ddd;
                $state = $data->payload->estado;
                $city  = $data->payload->cidade;

            } 

            $data = [
                'fullname'         => $request->input('fullname')       ?? 'Default',
                'email'            => $email                            ?? str_random('8') . '@defaul.com',
                'gender'           => $request->input('gender')         ?? 'M',
                'birthdate'        => $birthdate                        ?? '1990-01-01',
                'birthtime'        => $request->input('birthtime')      ?? '23:59',
                'state'            => $state                            ?? '',
                'city'             => $city                             ?? 'Default',
                'cep'              => $request->input('cep')            ?? '',
                'cpf'              => $request->input('cpf')            ?? null,      
                'ddd'              => $ddd                              ?? '',
                'phone_number'     => $request->input('ddd') ? '(' .    $request->input('ddd') . ')' : str_random(14),
                'source'           => $request->input('source')         ?? 'Default',
                'medium'           => $request->input('medium')         ?? 'Default',
                'campaign'         => $request->input('campaign')       ?? 'Default',
                'term'             => $request->input('term')           ?? 'Default',
                'content'          => $request->input('content')        ?? 'Default',
                'site_origin'      => $request->input('site_origin')    ?? 'sweetbonus.com.br/produtos',
                'indicated_from'   => $request->input('indicated_from') ?? null,
                'indicated_by'     => $request->input('indicated_by')   ?? null,
                'ip_address'       => $request->ip(),
                'invalid_cep'      => !isset($data->payload->ddd) ? true : false,
                'changed_password' => false,
                ''
            ];

            $response = $this->client->request('POST', self::ENDPOINT, [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'cache-control' => 'no-cache',
                    'accept'        => 'application/json',
                ],
                'json' => $data,
            ]);

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

            if ($data['status'] === 'email_exists') {
                return \GuzzleHttp\json_encode($data);
            }         

            if ($data['status'] == 'success') {
                $customer = $data['result'];
                $password = $data['password'];

                // UpdatePointsController::earn($data['result']['indicated_by']);

                /**
                 * Tell to listeners which a new customer was created.
                 */
                $created = new CustomerCreatedEvent($customer, $password);

                // Log::debug('Disparando evento `CustomerCreatedEvent`');

                event($created);

                // Log::debug('Evento `CustomerCreatedEvent` disparado');

                $request->session()->put([
                    'customer'     => $data['result'],
                    'idCustomer'   => $data['result']['id'],
                    'token'        => $data['token'],
                    'email'        => $data['result']['email'],
                    'birthdate'    => $data['result']['birthdate'],
                    'phone_number' => $ddd ?? '',
                    'gender'       => $data['result']['gender'],
                    'cep'          => $data['result']['cep'],
                    'name'         => $data['result']['fullname'],
               ]);

               self::createCustomerDevice($data['result']['id']);

            }
            
            if($request->input('action_type')) { 
                
                $ac_type = $request->input('action_type');

                if('insurance_research' == $ac_type) { //SEGURO AUTO
                    $action_type = 'Pesquisa Incentivada';        
                } else {
                    $action_type = self::getActionType($ac_type);
                }

                $params = [
                    'customer_id'  => $data['result']['id'],
                    'action_id'    => $request->input('action_id'),
                    'indicated_by' => $data['result']['indicated_by'],
                    'action_type'  => $action_type,
                ];

                if($params['customer_id'] != $params['indicated_by']) {
                    self::insertMGMAction($params);
                }
                
            }            

           return \GuzzleHttp\json_encode($data);

        } catch (ClientException $e) {
            $content = [];

            preg_match('/{.*}/i', $e->getMessage(), $content);

            return response()->json([
                'status' => $e->getCode(),
                'errors' => \GuzzleHttp\json_decode($content[0], true)['errors'],
            ], 422);
        }
    }

    private static function getActionType(int $action_type)
    {
        /**
         * verifica tipo de ação.
         */
        try {            
            $response = self::executeSweetApi(
                'GET',
                '/api/v1/frontend/actions/type/'. $action_type,
                []
            );
           
            return $response->data->name;
                
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

    private static function insertMGMAction($params)
    {
        try {
           
            $response = self::executeSweetApi(
                'POST',
                '/api/share-action/v1/frontend/share-action/',
                [
                    'customers_id'      =>  $params['customer_id'],
                    'indicated_by'      =>  $params['indicated_by'],
                    'action_type'       =>  $params['action_type'],                   
                    'action_id'         =>  $params['action_id'], 
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

    private static function createCustomerDevice(int $customerId) {
        $default = 'unknown';

        $customerDevice = [
            'customers_id'    => $customerId,
            'browser_name'    => Browser::browserName()     ?? $default,
            'browser_family'  => Browser::browserFamily()   ?? $default,
            'platform_name'   => Browser::platformName()    ?? $default,
            'platform_family' => Browser::platformFamily()  ?? $default,
            'device_family'   => Browser::deviceFamily()    ?? $default,
            'device_model'    => Browser::deviceModel()     ?? $default,
        ];

        try {
            $response = self::executeSweetApi(
                'POST',
                '/api/customer-device/v1/frontend/customer-device',
                $customerDevice
            );

            return $response; 

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    private static function callPricezApi ($cep) {
        try {

            $response = self::executeSweetApi(
                'GET',
                'http://ddd.pricez.com.br/cep/' . $cep['cep'] . '.json',
                []
            );

            return $response;            

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    public function hasEmail(Request $request)
    {
        return;
        // $response = $this->client->get(self::ENDPOINT . '/' . $request->get('email'), [
        //     'headers' => [
        //         'Content-Type' => 'application/json',
        //         'cache-control' => 'no-cache',
        //         'accept' => 'application/json',
        //     ]
        // ]);

        // $data = \GuzzleHttp\json_decode($response->getBody()->getContents());

        // if ($data->result == 1) {
        //     $request->session()->put([
        //         'customer' => $data->customer,
        //         'idCustomer' => $data->customer,
        //         'token' => $data->token,
        //         'birthdate' =>$data->data->birthdate,
        //         'phone_number' => $data->data->phone,
        //         'gender' => $data->data->gender,
        //         'cep' => $data->data->cep,
        //     ]);
        // }

        // return $data->result;
    }
}
