<?php

namespace App\Http\Controllers\MemberGetMember;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UpdatePointsController extends Controller
{

    public static function earn($customerId)
    {
        $customer = Customer::find($customerId);

        if(!empty($customer)){
            $customer->points += 10;
            $customer->save();
        }

    }

}