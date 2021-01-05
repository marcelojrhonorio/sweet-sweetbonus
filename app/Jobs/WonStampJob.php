<?php

namespace App\Jobs;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Traits\SweetStaticApiTrait;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Exception\BadResponseException;

class WonStampJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use SweetStaticApiTrait;

    public $timeout = 3000;

    private $customerStampId;

    private $endpoint;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customerStampId)
    {
        $this->customerStampId = $customerStampId;
        $this->endpoint = 'https://transacional.allin.com.br/api';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customerStamp = self::getCustomerStamp($this->customerStampId);

        if ($customerStamp) {

            $nextStamp = self::checkHasNext($customerStamp->stamp->id, 
                                            $customerStamp->stamp->type);

            $token = $this->renewToken();

            $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token=' . $token);      
            
            $html = view('emails.customers.won-stamp')->with([
                                'customer_stamp' => $customerStamp,
                                'next_stamp'     => $nextStamp['stamp'],
                                'has_next'       => $nextStamp['has_next']
                                ]);

            $json = [
                'nm_envio'        => explode(" ", $customerStamp->stamp_customers->fullname)[0],
                'nm_email'        => $customerStamp->stamp_customers->email,
                'nm_subject'      => 'Selo conquistado! \o/',
                'nm_remetente'    => 'Sweet Bonus',
                'email_remetente' => 'envio@sweetbonusclub.com',
                'nm_reply'        => 'envio@sweetbonusclub.com',
                'dt_envio'        => date('Y-m-d'),
                'hr_envio'        => date('H:i'),
                'html'            => base64_encode($html),
            ];
    
            $json = json_encode($json);
    
            $curl_post_data = ['dados' => $json];
    
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
            $curl_response = curl_exec($curl);
        }
    }

    private static function checkHasNext(int $stampId, int $type)
    {
        try {
            $response = self::executeSweetApi(
                'GET',
                '/api/stamps/v1/frontend/stamps?where[id]='.($stampId+1).'&where[type]='.$type,
                []
            );

            if($response->data) { 
                return [
                    'stamp'      => get_object_vars($response->data[0]),
                    'has_next'   => true
                ];                 
            }
            return [
                'stamp'      => [],
                'has_next'   => false
            ];

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

    private static function getCustomerStamp (int $customerStampId)
    {
        try {

            $response = self::executeSweetApi(
                'GET',
                '/api/stamps/v1/frontend/customer-stamps/' . $customerStampId,
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

    private function renewToken ()
    {
        $client = new Client(['base_uri' => $this->endpoint]);

        $params = [
            'method'   => 'get_token',
            'output'   => 'json',
            'username' => env('ALLIN_USER'),
            'password' => env('ALLIN_PASS'),
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query);

        $json = json_decode($response->getBody()->getContents());

        return $json->token;        
    }
}
