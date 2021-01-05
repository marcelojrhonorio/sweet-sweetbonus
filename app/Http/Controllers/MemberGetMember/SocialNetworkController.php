<?php

namespace App\Http\Controllers\MemberGetMember;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class SocialNetworkController extends Controller
{
    public static function getCode($origin)
    {

        $origin_codes = [
            'email'         =>  1,
            'whatsapp'      =>  2,
            'twitter'       =>  3,
            'facebook'      =>  4,
            'TrocaProdutos' =>  5,
            'direct'        =>  6,
        ];

        return $origin_codes[$origin] ?? 'Não encontrado';

    }
}
