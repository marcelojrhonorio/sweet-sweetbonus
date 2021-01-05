<?php

namespace App\Http\Controllers\MobileApp;

use Illuminate\Http\Request;
use App\Traits\SweetStaticApiTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class InviteAppController extends Controller
{
    use SweetStaticApiTrait;

    public function verfiyInviteApp(int $customerId)
    {
        try {

            $response = self::executeSweetApi(
                'POST',
                '/api/app-auth/v1/frontend/verify-invite/'.$customerId,
                []
            );
            
            $statusInviteApp = $response->data;

            switch ($statusInviteApp) {

                //O usuário já está em allowedCustomer!
                case 'app_user_allowed':
                    return redirect(env('URL_DOWNLOAD_APP')); 
                    break;

                //O usuário está habilitado a baixar o app!
                case 'app_user_download':
                    return redirect(env('URL_DOWNLOAD_APP'));   
                    break;
                
                //O usuário vai para a lista de espera!
                case 'app_user_add_waiting_list':
                    return view('app-mobile.message-app')->with([
                        'customerId' => $customerId,
                    ]);   
                    break;
                
                default:
                    return;
                    break;
            }

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        } catch (BadResponseException $exception) {
            Log::debug($exception->getMessage());
        }
    }

    public function createWaitingList(int $customerId)
    {
        try {

            $response = self::executeSweetApi(
                'POST',
                '/api/app-auth/v1/frontend/create-waiting-list/'.$customerId,
                []
            );

            return view('app-mobile.message-app')->with([
                'customerId' => $customerId,
                'data' => $response->data,
            ]);              
        
        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        } catch (BadResponseException $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
