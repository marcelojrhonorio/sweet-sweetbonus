<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RelationshipStepOneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customer;

    private $endpoint;

    /**
     * Create a new job instance.
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
        $this->endpoint = 'https://transacional.allin.com.br/api';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::debug('Processando job `RelationshipStepOneJob`');

        if ($this->wasReceived()) {
            return;
        }

        $token = $this->renewToken();

        $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token=' . $token);

        $html = view('emails.customers.welcome')->with([
            'customer' => $this->customer,
        ]);

        $json = [
            'nm_envio'        => $this->customer['fullname'],
            'nm_email'        => $this->customer['email'],
            'nm_subject'      => 'Seja bem-vindo ao mundo maravilhoso da Sweet!!',
            'nm_remetente'    => 'Sweet Bonus',
            'email_remetente' => 'envio@qualadicadehoje.com',
            'nm_reply'        => 'envio@qualadicadehoje.com',
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

        $customer          = Customer::find($this->customer->id);
        $customer->welcome = 1;
        $customer->save();

        Log::debug('Job `RelationshipStepOneJob` processado');
    }

    public function wasReceived()
    {
        $id       = $this->customer['id'];
        $customer = Customer::select('confirmed')->where('id', $id)->first();

        if (empty($customer)) {
            return false;
        }

        return $customer->welcome ? true : false;
    }

    /**
     * Renew All iN token.
     */
    private function renewToken()
    {
        $client = new Client(['base_uri' => $this->endpoint]);

        $params = [
            'method'   => 'get_token',
            'output'   => 'json',
            'username' => env('ALLIN_USER_QUALADICA'),
            'password' => env('ALLIN_PASS_QUALADICA'),
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query);

        $json = json_decode($response->getBody()->getContents());

        return $json->token;
    }
}
