<?php

namespace App\Http\Controllers\Alfacon;

use DB;
use DataTables;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
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

class ResultsController extends Controller
{
    use SweetStaticApiTrait;

    public function show () 
    {
        return view('alfacon.results');
    }

    public function search (Request $request)
    {
        $results = 
            DB::select("select alr.id, alr.fullname, alr.email, c.ddd, c.phone_number, alr.site_origin, alr.response, alr.created_at 
                from sweet_alfacon.lead_responses alr
                inner join sweet.customers c
                on alr.email = c.email;");

        $customers = [];
        foreach ($results as $r) {
            // If phone is null in customers table or phone in customers table is not a string.
            if(false === isset($r->phone_number) || preg_match_all("/[0-9]/", $r->phone_number) < 7) {
                $alr = DB::select("select phone from sweet_alfacon.lead_responses where email = '$r->email'");
                if(null !== $alr[0]->phone) {
                    $r->created_at = self::formatData($r->created_at);
                    $data = [
                        'id' => $r->id,
                        'fullname' => $r->fullname,
                        'email' => $r->email,
                        'ddd' => substr($alr[0]->phone, 0, 2),
                        'phone_number' => substr($alr[0]->phone, 2, 5) . '-' . substr($alr[0]->phone, 7, 4),
                        'site_origin' => $r->site_origin,
                        'response' => $r->response,
                        'created_at' => $r->created_at,
                    ];
                    array_push($customers, $data);
                }
            }

            if (isset($r->phone_number) && strlen($r->phone_number) > 8) {
                if (preg_match_all("/[0-9]/", $r->phone_number) > 7) {
                    $r->created_at = self::formatData($r->created_at);
                    $data = [
                        'id' => $r->id,
                        'fullname' => $r->fullname,
                        'email' => $r->email,
                        'ddd' => $r->ddd,
                        'phone_number' => $r->phone_number,
                        'site_origin' => $r->site_origin,
                        'response' => $r->response,
                        'created_at' => $r->created_at,
                    ];
                    array_push($customers, $data);
                }

            }
        }

        return datatables()->of($customers)->toJson();
    }

    private static function formatData ($dateTime) {
        $year  = substr($dateTime, 0, 4);
        $month = substr($dateTime, 5, 2);
        $day   = substr($dateTime, 8, 2);
        return ($day . '/' . $month . '/' . $year . ' ' .explode(' ', $dateTime)[1]);
    }

    public function searchEmail($email, Request $request) {

        $answers = DB::select("select * from sweet_alfacon.research_answers where research_id like '%".$email."%'");
        
        $allAnswers = [];

        foreach ($answers as $answer) {
            if(false === self::alreadyPushed($allAnswers, $answer->question_id)){
                $data = [
                    'question_id' => $answer->question_id,
                    'question' => self::getQuestionName($answer->question_id),
                    'options' => self::getAllOptionNames($answers, $answer->question_id)
                ];
                array_push($allAnswers, $data);
            }
        }

        return response()->json([
            'success' => true,
            'status'  => 'success',
            'message' => 'Imagem gravada com sucesso.',
            'data' => $allAnswers,
        ]);
    }

    private static function getAllOptionNames($answers, $questionId) {
        $allOptions = [];
        foreach ($answers as $answer) {
            if ($answer->question_id === $questionId) {
                array_push($allOptions, self::getOptionsName($answer->option_id));
            }
        }

        return $allOptions;
    }

    private static function getQuestionName($id) {
        $question = DB::select("select description from sweet_alfacon.research_questions where id = " . $id);
        return ($question[0]->description);
    }

    private static function getOptionsName($id) {
        $option = DB::select("select description from sweet_alfacon.research_options where id = " . $id);
        return ($option[0]->description);
    }

    private static function alreadyPushed($allAnswers, $id) {
        foreach($allAnswers as $answer) {
            if((int) $answer['question_id'] == $id) {
                return true;
            }
        }
        return false;
    }
}
