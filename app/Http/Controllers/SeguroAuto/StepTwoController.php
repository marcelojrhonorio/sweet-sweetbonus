<?php

namespace App\Http\Controllers\SeguroAuto;

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

class StepTwoController extends Controller
{
    use SweetStaticApiTrait;

    public function index(Request $request)
    {
        if($request->session()->has('id')){
            return view('seguro-auto.step02');
        }

        else {
            return redirect('/seguro-auto/info');
        }
    }

    public function redirect()
    {

    }

    public function store(Request $request)
    {
        $params = $this->getParams($request, $request->hasInsurance);
        Log::debug($params);

        $response = self::executeSweetApi(
            'POST',
            '/api/seguroauto/v1/frontend/customer-research-answers',
            $params
        );

        Log::debug(get_object_vars($response));

        return response()->json([
            'status' => 'success',
            'data'   => $response,
        ]);
    }

    private function getParams($request, $hasInsurance)
    {
        if ('true' === $hasInsurance){
            return $answerData = [
                'customer_research_answer_has_insurance'     => true,
                'customer_research_id'                       => (int) $request->session()->get('customerResearchId'),
                'model_year_id'                              => (int) $request->year,
                'customer_research_answer_status_sicronized' => 0,
                'insurance_company_id'                       => (int) $request->insurer,
                'customer_research_answer_date_insurace_at'  => $request->dateInsurance,
            ];              
        }

        return $answerData = [
            'customer_research_answer_has_insurance'     => false,
            'customer_research_id'                       => (int) $request->session()->get('customerResearchId'),
            'model_year_id'                              => (int) $request->year,
            'customer_research_answer_status_sicronized' => 0,
        ];   
    }
}