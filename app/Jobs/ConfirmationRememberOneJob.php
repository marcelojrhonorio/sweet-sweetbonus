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

class ConfirmationRememberOneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customerId;

    private $customer;

    private $password;

    private $endpoint;

    /**
     * Create a new job instance.
     */
    public function __construct($customerId, $password)
    {
        $this->customerId = $customerId;
        $this->customer   = Customer::find($this->customerId);
        $this->password   = $password;
        $this->endpoint   = 'https://transacional.allin.com.br/api';

        Log::debug($this->customer->email);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->wasConfirmed()) {
            return;
        }

        if (false === $this->isQualifiedDomain($this->customer->email)) {
            return;
        }

        $token = $this->renewToken();

        $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token=' . $token);

        $html = view('emails.customers.created')->with([
            'customer' => $this->customer->toArray(),
            'password' => $this->password,
        ]);

        $json = [
            'nm_envio'        => $this->customer->fullname,
            'nm_email'        => $this->customer->email,
            'nm_subject'      => 'Não esqueça de confirmar o seu e-mail',
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

        // After 72h send a confirmation remember.
        Log::debug('Disparando job `ConfirmationRememberTwoJob`');

        ConfirmationRememberTwoJob::dispatch($this->customerId, $this->password)
            ->delay(now()->addMinutes(3))
            ->onQueue('confirmation_remember_2');

        Log::debug('Job `ConfirmationRememberTwoJob` disparado');
    }

    /**
     * Check if customer was already confirmed
     */
    private function wasConfirmed()
    {
        Log::debug($this->customer);

        return $this->customer->confirmed ? true : false;
    }

    private function isQualifiedDomain($email)
    {
        $pattern = '/gmail\.com$|icloud.com$/';

        $patternMatches = preg_match($pattern, $email);

        return $patternMatches ? true : false;
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
            'username' => env('ALLIN_USER'),
            'password' => env('ALLIN_PASS'),
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query);

        $json = json_decode($response->getBody()->getContents());

        return $json->token;
    }
}
