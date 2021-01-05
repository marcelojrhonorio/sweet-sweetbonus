<?php

namespace App\Http\Controllers\Alfacon;

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

class ResearchInfoController extends Controller
{
    use SweetStaticApiTrait;

    public function index (Request $request)
    {
        $customerId = $request->query('customer_id') ?? null;
        $origin     = $request->query('site_origin') ?? null;
        
        /**
         * Set `site_origin` in session.
         */
        session(['site_origin' => $origin]);
        
        /**
         * If exists id parameter.
         */
        if (isset($customerId)) {
            $customer = self::getCustomer($customerId);

            /**
             * If customer is active.
             */
            if (isset($customer)) {
                $fullname = $customer->fullname;
                $email    = $customer->email;

                self::setCurrentUser($fullname, $email);
                return redirect('/alfacon');
            }

        }

        return view('alfacon.info');
    }

    public function fromForm (Request $request)
    {
        $fullname = $request->input('fullname') ?? null;
        $email    = $request->input('email') ?? null;
        $phone    = $request->input('phone') ?? null;

        if (!isset($fullname)) {
            return response()->json([
                'success' => true,
                'status'  => 'invalid_fullname',
                'message' => 'Por favor, informe seu nome!',
                'data' => [],
            ]);
        }

        if (!isset($email)) {
            return response()->json([
                'success' => true,
                'status'  => 'invalid_email',
                'message' => 'Por favor, informe seu email!',
                'data' => [],
            ]);            
        }

        if (!isset($phone)) {
            return response()->json([
                'success' => true,
                'status'  => 'invalid_email',
                'message' => 'Por favor, informe seu celular!',
                'data' => [],
            ]);            
        }

        self::setCurrentUser($fullname, $email, $phone);

        return response()->json([
            'success' => true,
            'status'  => 'success',
            'message' => 'Sucesso! Redirecionando...',
            'data' => [
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
            ],
        ]);
    }

    private static function setCurrentUser($fullname, $email, $phone) {
        session([
            'fullname'    => $fullname,
            'email'       => $email,
            'phone'       => $phone,
        ]);        
    }

    private static function getCustomer(int $id)
    {
        $response = self::executeSweetApi(
            'POST',
            '/api/v1/frontend/customers/' . $id,
            []
        );

        return $response->customer ?? null;
    }
}
