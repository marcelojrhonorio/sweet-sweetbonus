<?php

namespace App\Http\Controllers\BlogRegister;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BlogRegisterController extends Controller
{
    public function index ()
    {
        if (empty(session('comingFromBlog'))) {
            return redirect('/');
        }

        $comingFromBlog = session('comingFromBlog');

        $domain = preg_match("/(?:uat-sweetbonus)/", URL::current()) ? 'uat-sweetbonus' : 'sweetbonus';

        return view('index')->with([
            'data'   => $comingFromBlog,
            'page'   => 'produtos',
            'domain' =>  $domain,
        ]);
    }

    public function postback(Request $request)
    {
        $default = 'Não informado';
        
        $params = [
            'origin'       => $request->query('utm_source', $default),
            'campaign'     => $request->query('utm_campaign', $default),
        ];
        
        if(($params['origin'] === $default) || ($params['origin'] !== 'blog')) {
            Log::debug('invalid origin');
            return redirect('/');
        }

        if(($params['campaign'] === $default) || ($params['campaign'] !== 'BlogRegister')) {
            Log::debug('invalid campaign');
            return redirect('/');
        }

        return redirect('/coming-from-blog?utm_source=' . $params['origin'] . '&utm_campaign=' . $params['campaign'])
            ->with('comingFromBlog', [
                'comming_from'  => 'blog',
            ]);        
    }
}
