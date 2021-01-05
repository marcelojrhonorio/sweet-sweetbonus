<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsOfUseController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function conditions(Request $request)
    {
        return view('conditions');
    }

    public function conditionsSweet(Request $request)
    {
        return view('conditions-sweet');
    }
    /**
     * @todo Add docs.
     */
    public function privacy(Request $request)
    {
        return view('privacy');
    }

    public function privacySweet(Request $request)
    {
        return view('privacy-sweet');
    }
}
