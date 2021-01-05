<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    public function index()
    {
        $customer = Customer::find(session()->get('idCustomer'));

        if (is_null($customer->campaign_ended_at)) {
            $customer->campaign_ended_at = Carbon::now()->toDateTimeString();
            $customer->save();
        }

        $query = http_build_query([
            'email'    => session('email'),
            'password' => env('CHANGE_PASS') ? self::formatBirthdate(session('birthdate')) : session('_rawpass'),
        ]);

        Log::debug(env('CHANGE_PASS') ? self::formatBirthdate(session('birthdate')) : session('_rawpass'));

        session()->forget('gender');
        session()->forget('phone_number');
        session()->forget('cep');
        session()->forget('birthdate');
        session()->forget('email');
        session()->forget('_rawpass');

        $url = env('STORE_URL') . '/login?' . $query;

        Log::debug($url);

        return redirect()->to($url);
    }

    private static function formatBirthdate($birthdate) {
        $bday = explode("-", $birthdate);
        return ($bday[2] . '/' . $bday[1] . '/' . $bday[0]);
    }
}
