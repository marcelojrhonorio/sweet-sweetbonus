<?php

namespace App\Http\Controllers\Quiz;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ResearchesController extends Controller
{
    public function index(Request $request)
    {
        if (!env('QUIZ_RESEARCH')){
            return redirect('/');
        }

        if('1' === $request->query('id')){
            return view('quiz.research')->with('id', 1);
        }

        if('2' === $request->query('id')){
            return view('quiz.research')->with('id', 2);            
        }

        Log::debug('Aqui');
        return view('quiz.research')->with('id', 3);
    }

    public function final(Request $request)
    {
        if (!env('QUIZ_RESEARCH')){
            return redirect('/');
        }

        return view('quiz.final');
    }

    public function store(Request $request)
    {
        $request->query('id');

        if (!env('QUIZ_RESEARCH')){
            return redirect('/');
        }

        $redirect = [
            '1' => 'http://sp.lattrk2.com/aff_c?offer_id=5249&aff_id=10249&aff_sub=PES',
            '2' => 'http://tracking.surveycheck.com/aff_c?offer_id=90&aff_id=10200&aff_sub=PES',
            '3' => 'https://ad.trackedblds.com/aff_c?offer_id=2953&aff_id=3481&url_id=32754&aff_sub=PES',
        ];

        if('1' == $request->query('id')) {
            return redirect('/quiz/final')->with([
                'redirect' => $redirect['1'],
                ]);    
        }

        if('2' == $request->query('id')) {
            return redirect('/quiz/final')->with([
                'redirect' => $redirect['2'],
                ]);    
        }        

        return redirect('/quiz/final')->with([
            'redirect' => $redirect['3'],
            ]);

    }        
}
