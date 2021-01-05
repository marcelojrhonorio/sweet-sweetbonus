<?php

namespace App\Http\Controllers\RaptorSurvey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RaptorSurveyController extends Controller
{
    public function showForm (Request $request) 
    {
        $customerId = $request->query('customers_id');

        if (null === $customerId) {
            return redirect('/');
        }

        return view('raptor.research')->with('customerId', $customerId);
    }

    public function showNoProfile (Request $request)
    {
        return view('raptor.no-profile');
    }

    public function store (Request $request)
    {

    }
}
