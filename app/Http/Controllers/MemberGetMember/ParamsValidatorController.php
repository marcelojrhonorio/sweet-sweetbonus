<?php

namespace App\Http\Controllers\MemberGetMember;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MemberGetMember\SocialNetworkController;        

class ParamsValidatorController extends Controller
{

    public static function verify($params)
    {
        $result = true;

        $commingFrom = SocialNetworkController::getCode($params['origin']);
        is_numeric($commingFrom) ?: $result = false;
        
        $customer = Customer::find($params['customer_id']);
        !empty($customer) ?: $result = false;

        'MemberGetMember' === $params['campaign'] ?: $result = false;

        return $result;

    }

}