<?php

namespace App\Http\Controllers\SeguroAuto;

use Carbon\Carbon;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Traits\SweetStaticApiTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class StepOneController extends Controller
{
    use SweetStaticApiTrait;

    public function index(Request $request)
    {
        if($request->session()->has('id'))
        {

            return view('seguro-auto.step01');

        } else {

            return redirect('/seguro-auto/info');
        
        }
    }

    public function redirect(Request $request)
    {
        $id = $request->query('step_id');

        $params = [];

        $params['customer_id']              = $request->session()->get('id');
        $params['has_car']                  = '1' == $request->query('has_car') ? true : false;
        $params['completed']                = $params['has_car'] ? 0 : 1;
        $params['customer_research_points'] = $params['has_car'] ? 0 : 100;

        if (is_null($id)) {
            return redirect ('/seguro-auto/step-one');
        }

        //verify MEMBER_GET_MEMBER_ACTION
        $c = self::getCustomer($params['customer_id']);
        $indicated_by = $c->customer->indicated_by;

        $mgmAction = self::verifyMGMAction($params['customer_id'], $indicated_by);

        if($mgmAction && (null === $mgmAction[0]->won_points)) {
            self::updateWonPoints($mgmAction);
        }

        $customerResearchResponse = $this->saveCustomerResearch($params);
        $request->session()->put(['customerResearchId' => $customerResearchResponse]);
        
        if ($params['has_car']) {
            return redirect('/seguro-auto/step-two');
        }

        $data = $this->getRedirectPageMessage($id);

        if (is_null($data)) {
            Log::debug('Invalid step_id');
            return;
        }

        return view('seguro-auto.redirect')
                ->with(['data' => $data]);
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

    private function saveCustomerResearch ($data) 
    {
        try {
            $response = self::executeSweetApi(
                'POST',
                '/api/seguroauto/v1/frontend/customer-researches',
                $data
            );

            return $response->data->id;

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

    private function getRedirectPageMessage ($id)
    {
        switch($id){
            case '1': 
                
                $data = [
                    'redirect_link' => env('APP_URL') . '/english-live',
                    'title'         => 'Você não tem perfil para esta pesquisa.',
                    'subtitle'      => 'Redirecionando para outra que você tem perfil',
                ];

                return $data;

            break;
        }
    }


    private static function updateWonPoints($mgmAction)
    {
        $id = $mgmAction[0]->id;
        $customers_id = $mgmAction[0]->customers_id;
        $indicated_by = $mgmAction[0]->indicated_by->indicated_by;
        $action_type = $mgmAction[0]->action_type;
        $action_id = $mgmAction[0]->action_id;

        //atribui a pontuação ao usuário que compartilhou
        self::updateCustomerPoints($indicated_by, 5);  

        try {

            $response = self::executeSweetApi(
                'PUT',
                '/api/share-action/v1/frontend/share-action/'.$id,
                [
                    'customers_id'  => $customers_id,
                    'indicated_by'  => $indicated_by,
                    'action_type'   => $action_type,
                    'action_id'     => $action_id,
                    'won_points'    => Carbon::now()->toDateTimeString(),
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

    private static function updateCustomerPoints(int $indicated_by, int $points)
    {
        try {

            $response = self::executeSweetApi(
                'PUT',
                '/api/v1/frontend/customers/update-customer/points?indicated_by='.$indicated_by.'&points='.$points,
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


    private static function verifyMGMAction($customers_id, $indicated_by)
    {
        $action_id = 0;  

        try {            
            $response = self::executeSweetApi(
                'GET',
                '/api/share-action/v1/frontend/share-action?where[customers_id]='.$customers_id.
                                                          '&where[indicated_by]='.$indicated_by.
                                                          '&where[action_id]='.$action_id,
                []
            );
           
            return $response->data;
                
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
