<?php

namespace App\Http\Controllers\MemberGetMember;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Irazasyed\LaravelGAMP\Facades\GAMP;
use App\Http\Controllers\MemberGetMember\SocialNetworkController;
use App\Http\Controllers\MemberGetMember\ParamsValidatorController;

class PostbackController extends Controller
{

    public function postback(Request $request)
    {
        $default = 'Não informado';

        $params = [
            'origin'       => $request->query('utm_source', $default),
            'campaign'     => $request->query('utm_campaign', $default),
            'customer_id'  => $request->query('customer_id', $default),
        ];

        $validator = ParamsValidatorController::verify($params);

        if(!$validator){
            Log::debug('Invalid params');
            return redirect('/');
        }

        // $gamp = GAMP::setClientId( '115220710' );
        // $gamp->setDocumentPath( $request->fullUrl() );
        // $gamp->sendPageview();

        $customer = Customer::find($params['customer_id']);
        $customerName = explode(" ", $customer->fullname)[0];
        
        $commingFrom = SocialNetworkController::getCode($params['origin']);
        
        return redirect('/compartilhar?utm_source=' . $params['origin'] . '&utm_campaign=' . $params['campaign'])
            ->with('comingFromSocialNetwork', [
                'customer_id'          => $params['customer_id'],
                'customer_name'        => $customerName,
                'comming_from'         => $commingFrom,
                'register_from_action' => false,
            ]);

    }

    public function postbackActions(Request $request)
    {
        $default = 'Não informado';

        $params = [
            'customer_id'    => $request->query('customer_id', $default),
            'action_id'      => $request->query('action_id', $default),
            'action_type'    => $request->query('action_type', $default),  
        ];
        
        $customer = Customer::find($params['customer_id']);
        $customerName = explode(" ", $customer->fullname)[0];

        $commingFrom = SocialNetworkController::getCode('facebook');

        return redirect('/compartilhar?utm_source=facebook&utm_campaign=MemberGetMember')
            ->with('comingFromSocialNetwork', [
                'customer_id'          => $params['customer_id'],
                'customer_name'        => $customerName,
                'action_id'            => $params['action_id'],
                'action_type'          => $params['action_type'],
                'comming_from'         => $commingFrom,
                'register_from_action' => true,
            ]);
    }


    

}