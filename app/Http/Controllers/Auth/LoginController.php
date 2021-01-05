<?php

namespace App\Http\Controllers\Auth;

use Session;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\CustomerVerifiedEvent;

class LoginController extends Controller
{
    /**
     * @todo Add docs.
     */
    protected $client;

    /**
     * @todo Add docs.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('APP_SWEET_API'),
            'http_errors' => false,
            'headers'  => [
                'cache-control' => 'no-cache',
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
            ],
        ]);
    }

    public function index(Request $request)
    {
        return view('login');
    }

    /**
     * @todo Add docs.
     */
    protected function setCurrentUser($customer)
    {
        session([
            'id'                => $customer->id,
            'name'              => isset($customer->name) ? $customer->name : $customer->fullname,
            'email'             => $customer->email,
            'birthdate'         => $customer->birthdate,
            'token'             => $customer->token,
        ]);
    }

    /**
     * @todo Add docs.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'bail|required|email',
            'password' => 'required',
        ]);

        $authorized = [
            'smith.junior@icloud.com',
            'marcelo.campos.honorio@gmail.com',
            'bruno@sweetmedia.com.br',
            'bruno@canoadigital.com'
        ];

        if(!in_array($request->input('email'), $authorized)){
            return redirect('/login')->with('alert', [
                'type'    => 'warning',
                'message' => 'Usuário não autorizado.',
            ]);            
        }

        $endpoint = 'api/v1/customers/login';
        $options  = ['json' => $request->only(['email', 'password'])];
        $response = $this->client->post($endpoint, $options);

        $body    = $response->getBody()->getContents();
        $content = \GuzzleHttp\json_decode($body);

        if (false === $content->success) {
            return redirect('/login')->with('alert', [
                'type'    => 'warning',
                'message' => 'E-Mail ou Senha inválidos.',
            ]);
        }

        $this->setCurrentUser($content->data);

        return redirect('/logs');
    }
}
