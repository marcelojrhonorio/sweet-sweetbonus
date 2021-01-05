<?php

namespace App\Http\Controllers\ResearchSponsored;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use App\Jobs\WonStampJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SweetStaticApiTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\ResearchSponsored\Option;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use App\Models\ResearchSponsored\Research;
use App\Models\ResearchSponsored\Question;
use App\Models\ResearchSponsored\MiddlePage;
use GuzzleHttp\Exception\BadResponseException;
use App\Models\ResearchSponsored\QuestionOption;
use App\Models\ResearchSponsored\ResearchQuestion;
use App\Models\ResearchSponsored\ResearchMiddlePage;

class ResearchesController extends Controller
{
    use SweetStaticApiTrait;
    protected $won_points_research = false;

    public function final(Request $request, $middlePageId)
    {
        $middlePage = self::getMiddlePage($middlePageId); 
           
        if($middlePage) {

            $aux = get_object_vars($middlePage);

            return view('researches.final')->with([
                'redirect' => $aux['redirect_link'],
                'image_path' => $aux['image_path'],
                'middle_title' => $aux['title'],
                'middle_description' => $aux['description']
             ]);   
        }

        return view('researches.final');
    }

    public function index(Request $request, $url, $customers_id)
    {   
        $research = self::getResearchByUrl($url);

        if (is_null($research) || !$research->enabled){
            return redirect('/');
        } 

        return view('researches.research-new')->with([
            'research' => $research,
            'customers_id' => $customers_id,
        ]);

        /*
        if (is_null($research) || !$research->enabled){
            return redirect('/');
        } 

        $research_questions =self::getResearchQuestions($research->id); 
       
        $questions = [];
        $questionsOneAnswer = '';
        $questionsMoreAnswer = '';
       
        foreach($research_questions as $research_question) 
        {                        
            $question = self::getQuestion($research_question->questions_id);
            array_push($questions, $question);

            if($question->one_answer) {
                $questionsOneAnswer = $questionsOneAnswer . '|' . $question->id;
            } else {
                $questionsMoreAnswer = $questionsMoreAnswer . '|' . $question->id;
            }
        }  
        
        $question_options = [];
        
        foreach($questions as $question) 
        {
            $question_option = self::getQuestionOption($question->id); 
            array_push($question_options, $question_option);
        } 

        $options = []; 

        foreach($question_options as $question_option) 
        {
            foreach($question_option as $qo)
            {  
                $option = self::getOption($qo->options_id);
                array_push($options, $option);
            }            
        } 
        
        $researchMiddlePages = self::getResearchMiddlePage($research->id); 

        $middlePages = [];
        
        foreach($researchMiddlePages as $researchMiddlePage) 
        {
            $middlePage = self::getMiddlePage($researchMiddlePage->middle_pages_id); 
                        
            $flag = 0;

            if(empty($middlePages)) {
                array_push($middlePages, $middlePage);
            } else {
                
                foreach($middlePages as $middle) 
                {                
                    if($middle->id == $middlePage->id) {
                       $flag++;
                    }
                }

                if(0 == $flag){
                    array_push($middlePages, $middlePage);
                }
            }           
        } 

        return view('researches.research')->with([
            'research' => $research,
            'research_questions' => $research_questions,
            'questions' => $questions,
            'question_options' => $question_options,
            'options' => $options,
            'researchMiddlePages' => $researchMiddlePages,
            'middlePages' => $middlePages,
            'customers_id' => $customers_id,
            'questionsOneAnswer' => $questionsOneAnswer,
            'questionsMoreAnswer' => $questionsMoreAnswer,
        ]);
        */
    }

    public function verifyResearch(Request $request)
    {
        $researches_id = $request->get('researches_id');
        $customers_id = $request->get('customers_id');

        try{

            $response = self::executeSweetApi(
                'POST',
                '/api/researches/v1/frontend/customer_researches/verify',
                [
                    'researches_id' => $researches_id,
                    'customers_id' => $customers_id,
                ]
            );

            if($response) {
                return response()->json([
                    'success' => true,
                    'data' => $response,
                ]);  
            }

            return response()->json([
                'success' => false,
                'data' => [],
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

    public function getData(Request $request)
    {
        $final_url = $request->get('final_url');
        $customers_id = $request->get('customers_id');

        $research = self::getResearchByUrl($final_url);

        if (is_null($research) || !$research->enabled){
            return redirect('/');
        } 

        $research_questions =self::getResearchQuestions($research->id); 
       
        $questions = [];
        $questionsOneAnswer = '';
        $questionsMoreAnswer = '';
       
        foreach($research_questions as $research_question) 
        {                        
            $question = self::getQuestion($research_question->questions_id);
            array_push($questions, $question);

            if($question->one_answer) {
                $questionsOneAnswer = $questionsOneAnswer . '|' . $question->id;
            } else {
                $questionsMoreAnswer = $questionsMoreAnswer . '|' . $question->id;
            }
        }  
        
        $question_options = [];
        
        foreach($questions as $question) 
        {
            $question_option = self::getQuestionOption($question->id); 
            array_push($question_options, $question_option);
        } 

        $options = []; 

        foreach($question_options as $question_option) 
        {
            foreach($question_option as $qo)
            {  
                $option = self::getOption($qo->options_id);
                array_push($options, $option);
            }            
        } 
        
        $researchMiddlePages = self::getResearchMiddlePage($research->id); 

        $middlePages = [];
        
        foreach($researchMiddlePages as $researchMiddlePage) 
        {
            $middlePage = self::getMiddlePage($researchMiddlePage->middle_pages_id); 
                        
            $flag = 0;

            if(empty($middlePages)) {
                array_push($middlePages, $middlePage);
            } else {
                
                foreach($middlePages as $middle) 
                {                
                    if($middle->id == $middlePage->id) {
                       $flag++;
                    }
                }

                if(0 == $flag){
                    array_push($middlePages, $middlePage);
                }
            }           
        } 

        return response()->json([
            'success' => true,
            'data' => [
                'research' => $research,
                'research_questions' => $research_questions,
                'questions' => $questions,
                'question_options' => $question_options,
                'options' => $options,
                'researchMiddlePages' => $researchMiddlePages,
                'middlePages' => $middlePages,
                'customers_id' => $customers_id,
                'questionsOneAnswer' => $questionsOneAnswer,
                'questionsMoreAnswer' => $questionsMoreAnswer,
            ],
        ]);
     
    }

    public function store(Request $request)
    {
        $options = $request->all();
        $counter = 0;
        $redirect = '';
        $image_path = '';
        $middle_title = '';
        $middle_description = '';
        $researches_id = '';
        $customers_id = '';
        $questions_id = '';
        $flag = false;
        $default = 'nao informado';
        
        foreach($options as $option)
        {
            /** ignore first param _token and aff_id */
            $counter += 1;
            if ($counter !== 1){

                if(is_array($option)){
                    
                    foreach($option as $option_checkbox){

                        $middle_pages_id = '';
                        $tags = $option_checkbox;
                        $termo = 'middle';  
                        $middlePage = null;                  
    
                        /**
                         * Tratamento para pegar os valores de option e middle_pages_id
                         */
    
                        $pattern = '/' . $termo . '/';
    
                        if (preg_match($pattern, $tags)) {                       
                            $array = explode($termo, $tags);
    
                            $option_checkbox = $array[0];
                            $middle_pages_id = $array[1];   
                            
                            $middlePage = self::getMiddlePage($middle_pages_id);
                            $redirect = $middlePage->redirect_link;
                            $image_path = $middlePage->image_path;
                            $middle_title = $middlePage->title;
                            $middle_description = $middlePage->description;
    
                        } else {
                            $option_checkbox = explode("-", $option_checkbox)[1];
                        }
                        
                        $question_option = self::getQuestionOptionByOptionsId($option_checkbox); 
    
                        if($question_option) {                            
                            $questions_id = $question_option->questions_id;
                        }

                        /**
                         * Verifica-se se existe CustomerResearches, 
                         * impedindo de armazenar a resposta a um usuário que já respondeu.
                         */

                         $result = self::verifyCustomerResearches($customers_id, $researches_id);                      

                         if(is_null($result)) {
                            $storedAnswer = self::storeResearchAnswers($customers_id, $customers_id, $questions_id, $researches_id, $option_checkbox);
                         } else {
                            $flag = true;
                        }
                    }

                } else {

                    $middle_pages_id = '';
                    $tags = $option;
                    $termo = 'middle';  
                    $middlePage = null;                  

                    /**
                     * Tratamento para pegar os valores de option e middle_pages_id
                     */

                    $pattern = '/' . $termo . '/';

                    if (preg_match($pattern, $tags)) {                       
                        $array = explode($termo, $tags);

                        $option = $array[0];
                        $middle_pages_id = $array[1];   
                        
                        $middlePage = self::getMiddlePage($middle_pages_id);
                        $redirect = $middlePage->redirect_link;
                        $image_path = $middlePage->image_path;
                        $middle_title = $middlePage->title;
                        $middle_description = $middlePage->description;

                    } else {
                        $option = explode("-", $option)[1];
                    }

                    if(2 === $counter) {

                        $researches_id = $option;                       

                    } else if(3 === $counter) {

                        $customers_id = $option;
                        
                        $customer = self::verifyCustomer($customers_id);

                        if($customer) {

                            $research = self::getResearch($researches_id);

                            /**
                             * Verifica-se se existe CustomerResearches, 
                             * impedindo de atribuir a pontuação a um usuário que já respondeu.
                             */

                            $result = self::verifyCustomerResearches($customer->id, $researches_id);

                            if(is_null($result)) {
                                self::updateCustomerPoints($customer->id, $research->points);
                            }

                        } else {
                            //não tem customer
                            $customers_id = str_random('8');
                        }
                    }
                    else {
                        $question_option = self::getQuestionOptionByOptionsId($option); 

                        if($question_option) {                            
                            $questions_id = $question_option->questions_id;
                        }
                       
                        /**
                         * Verifica-se se existe CustomerResearches, 
                         * impedindo de armazenar a resposta a um usuário que já respondeu.
                         */

                        $result = self::verifyCustomerResearches($customers_id, $researches_id);

                         if(is_null($result)) {                             
                            $storedAnswer = self::storeResearchAnswers($customers_id, $customers_id, $questions_id, $researches_id, $option);
                         } else {
                             $flag = true;
                         }                       
                    }                  
                }
            }
        }        

        /**
         * criar CustomerResearches somente se existir Customer
         * e não existir CustomerResearches
         */
        
        if(!$flag && $customer) {
            self::createCustomerResearches($customers_id, $researches_id);
        }        

        return redirect('/research/final')->with([
           'redirect' => $redirect,
           'image_path' => $image_path,
           'middle_title' => $middle_title,
           'middle_description' => $middle_description
        ]);        
    }

    public function saveResearchAnswer(Request $request)
    {
        $researches_id = $request->get('researches_id');       
        $customers_id = $request->get('customers_id');       
        $questions_id = $request->get('question');       
        $options_id = $request->get('options_id');      
        $middle_pages_id = $request->get('middle_pages_id');   
        $finish_research = $request->get('finish_research'); 
        $answer_is_array = $request->get('is_array'); 
        $last_index = $request->get('last_index');
        
        $answered_research = false;        
        $storedAnswer;

       // Log::debug('question:' . $questions_id . ' options:' . $options_id);

        //verifica se existe customer. Caso contrário cria um hash
        $customer = self::verifyCustomer($customers_id);        

        /**
        * Verifica-se se existe CustomerResearches, 
        * impedindo de armazenar a resposta a um usuário que já respondeu.
        */

        if(is_null($customer)) {
            $customers_id = str_random('8');
        }
        
        $result = self::verifyCustomerResearches($customers_id, $researches_id);

        if(is_null($result)) { 
            $storedAnswer = self::storeResearchAnswers($customers_id, $customers_id, $questions_id, $researches_id, $options_id);
        } else {
            $answered_research = true;
            $updateAnswer = self::updateResearchAnswers($customers_id, $customers_id, $questions_id, $researches_id, $options_id, $answer_is_array);
        }         

        if(!is_null($customer)) 
        {
            //Pesquisa finalizada?
            if($finish_research) 
            {
                $research = self::getResearch($researches_id);

                /**
                * Verifica-se se existe CustomerResearches, 
                * impedindo de atribuir a pontuação a um usuário que já respondeu.
                */  

                if(is_null($result)) {
                    if($answer_is_array) {
                        if($last_index) {
                            self::updateCustomerPoints($customer->id, $research->points);
                        }                           
                    } else {
                        self::updateCustomerPoints($customer->id, $research->points);
                    }
                }   
            }  
        } 

        //Pesquisa finalizada?
        if($finish_research) {
            if(!$answered_research && $customer) {  
                self::createCustomerResearches($customers_id, $researches_id);
            }                         

            return response()->json([
                'success' => true,
                'has_middle' => [],            
                'data' => $middle_pages_id,            
            ]);                 
        }

        return response()->json([
            'success' => true,
            'data' => [],            
        ]);

    }

    private static function createCustomerResearches($customers_id, $researches_id)
    {
        try {

            $response = self::executeSweetApi(
                'POST',
                '/api/researches/v1/frontend/customer_researches/',
                [
                    'researches_id' => $researches_id,
                    'customers_id' => $customers_id
                ]
            );

            //increment of count_to_stamp of the Sweet Researches stamp
            self::incrementSweetResearchesStamp($customers_id, 3);

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

    private static function incrementSweetResearchesStamp($customerId, $actionType)
    {
        //somente 'customerStamps' não finalizados
        $customerStamps = self::getCustomerStamps($customerId, $actionType);

        //somente 'stamps' não finalizados
        $stamps = self::getStamps($customerId, $actionType);

        /**
         * Se o usuário ainda não fez nenhuma ação para tal.
         */
        if (0 === count($customerStamps)) {
               self::createCustomerStamp($stamps[0]->id, $customerId);                    
        }

         /**
         * Se existir um selo cadastrado para o $actionType
         * e o usuário já fez mo mínimo uma ação para tal.
         */
        if (0 !== count($customerStamps)) {
               self::updateCustomerStamp($customerStamps);
        }
    }

    private static function updateCustomerStamp($customerStamps)
    {
        $i = 0;
        $customerStamp = '';

        for ($i; $i <= count($customerStamps); $i++) 
        {
            if ((int) $customerStamps[$i]->count_to_stamp < (int) $customerStamps[$i]->stamp->required_amount) 
            {                
                $customerStamp = $customerStamps[$i];
                break;
            }
        }

        try {

            $customerStamp->count_to_stamp += 1;

            $response = self::executeSweetApi(
                'PUT',
                '/api/stamps/v1/frontend/customer-stamps/' . $customerStamp->id,
                $customerStamp
            );

            /**
             * Se o usuário atingiu a quantidade de ações para ganhar o selo,
             * irá disparar a Job informando que ele ganhou.
             */
            if ((int) $customerStamp->stamp->required_amount === $response->data->count_to_stamp) {
                self::wonStamp($customerStamp);
            }

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

    private static function wonStamp($customerStamp)
    {
        WonStampJob::dispatch($customerStamp->id)->onQueue('won_stamp_customer');
    }

    private static function createCustomerStamp(int $stampId, int $customerId)
    {
        try {

            $response = self::executeSweetApi(
                'POST',
                '/api/stamps/v1/frontend/customer-stamps/',
                [
                    'customers_id' => $customerId,
                    'stamps_id' => $stampId,
                    'count_to_stamp' => 1
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

    private static function getStamps(int $customerId, string $actionType) {
        
        try {

            $stamps = self::executeSweetApi(
                'GET',
                '/api/stamps/v1/frontend/stamps?where[type]=' . $actionType,
                []
            );
   
            $s = [];
            $stamps = $stamps->data;

            $i = 0;

            for ($i; $i < count($stamps); $i++) {
                $customerStamps = self::executeSweetApi(
                    'GET',
                    '/api/stamps/v1/frontend/customer-stamps?where[customers_id]=' . $customerId .
                    '&where[stamps_id]=' . $stamps[$i]->id,
                    []
                );

                $countToStamp = isset($customerStamps->data[0]->count_to_stamp) ? (int) $customerStamps->data[0]->count_to_stamp : 'empty';

                if (is_string($countToStamp) || (int) $customerStamps->data[0]->count_to_stamp < $stamps[$i]->required_amount) {
                    array_push($s, $stamps[$i]);
                }
            }

            return $s;

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    private static function getCustomerStamps(int $customerId, string $actionType) {

        try {
            
            $customerStamps = self::executeSweetApi(
                'GET',
                '/api/stamps/v1/frontend/customer-stamps?where[customers_id]=' . $customerId,
                []
            );

            $cs = [];
            $customerStamps = $customerStamps->data;

            $i = 0;

            for ($i; $i < count($customerStamps); $i++) {
                
                $condition1 = $customerStamps[$i]->stamp->type === $actionType;
                $condition2 = (int) $customerStamps[$i]->stamp->required_amount > 
                              (int) $customerStamps[$i]->count_to_stamp;

                if ($condition1 && $condition2) {
                    array_push($cs, $customerStamps[$i]);
                }
            }

            return $cs;

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    private static function verifyCustomerResearches($customers_id, $researches_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/customer_researches?where[researches_id]=' . $researches_id . '&where[customers_id]=' . $customers_id,
                []
            );

            if(!$response->data) {
                return null;
            }

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

    private static function getResearch($researches_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/researche/' . $researches_id,
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

    private static function updateCustomerPoints($customer_id, $points)
    {
        try{

            $response = self::executeSweetApi(
                'POST',
                '/api/researches/v1/frontend/customer/update-points',
                [
                    'indicated_by' => $customer_id,
                    'points' => $points,
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

    private static function verifyCustomer($customers_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/customer/' . $customers_id,
                []
            );

            if($response->success) {
                return $response->customer;
            }

            return null;

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

    private static function updateResearchAnswers($customers_id, $respondent, int $questions_id, int $researches_id, int $options_id, $answer_is_array)
    {
        try {

            $data = [
                'customers_id'  => $customers_id,
                'respondent'    => $respondent,
                'questions_id'  => $questions_id,
                'researches_id' => $researches_id,
                'options_id'    => $options_id,
                'answer_is_array' => $answer_is_array,
            ];

            $response = self::executeSweetApi(
                'POST',
                '/api/researches/v1/frontend/researche-answer/update',
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

    private static function storeResearchAnswers ($customers_id, $respondent, int $questions_id, int $researches_id, int $options_id) 
    {
        try {

            $data = [
                'customers_id'  => $customers_id,
                'respondent'    => $respondent,
                'questions_id'  => $questions_id,
                'researches_id' => $researches_id,
                'options_id'    => $options_id,
            ];

            $response = self::executeSweetApi(
                'POST',
                '/api/researches/v1/frontend/researche-answer',
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

    private static function getQuestionOptionByOptionsId($options_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/question-option/get-question-option-by-option/' . $options_id,
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

    private static function getMiddlePage($middle_pages_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/middle-page/' . $middle_pages_id,
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

    private static function getResearchMiddlePage($research_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/researches-middle-page/get-research-middle-page/' . $research_id,
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

    private static function getOption($options_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/option/' . $options_id,
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

    private static function getQuestionOption($questions_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/question-option/get-question-option/' . $questions_id,
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

    private static function getQuestion($questions_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/question/' . $questions_id,
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

    private static function getResearchQuestions($research_id)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/researche-question/get-research-question/' . $research_id,
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

    private static function getResearchByUrl(string $url)
    {
        try{

            $response = self::executeSweetApi(
                'GET',
                '/api/researches/v1/frontend/researche/verify-url/' . $url,
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
}
