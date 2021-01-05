<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreMediatorController extends Controller
{
    public function login(Request $request)
    {
        $query = http_build_query([
            'email'    => $request->input('login_email'),
            'password' => $request->input('login_password'),
        ]);

        $url = env('STORE_URL') . '/login?' . $query;

        return redirect()->to($url);
    }
}
