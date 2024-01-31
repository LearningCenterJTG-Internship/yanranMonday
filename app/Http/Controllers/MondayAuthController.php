<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use monday\Client\Auth\OAuth\ApiException;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use \App\Models\MondayToken;
use App\Models\Contact;
use App\Models\User;

class MondayAuthController extends Controller
{
    protected $monday_scopes = [
        'me:read',
        'boards:read',
        'boards:write',
        'updates:read',
        'updates:write',
        'account:read',
    ];    

    # redirect to monday authorization
    public function redirectToMonday()
    {
        $scopes = $this->monday_scopes;
        $query = http_build_query([
            'client_id' => config('services.monday.client_id'),
            'redirect_uri' => config('services.monday.redirect'),
            'scope' => implode(' ', $scopes),
            'response_type' => 'code',
            'state' => bin2hex(random_bytes(16)),
        ]);
        return redirect('https://auth.monday.com/oauth2/authorize?' . $query);
    }

    # callback to get token
    public function handleMondayCallback(Request $request)
    {
        \Log::info("??????");
        $http = new Client(['verify' => false]);
        $code = $request->query('code');
        $state = $request->query('state');

        \Log::info("this is: ", $request->code);

        $response = $http->post('https://auth.monday.com/oauth2/token', [
            'form_params' => [
                'client_id' => config('services.monday.client_id'),
                'client_secret' => config('services.monday.client_secret'),
                'code' => $code,
                'redirect_uri' => config('services.monday.redirect'),
                'grant_type' => 'authorization_code',
            ],
        ]);

        $token = json_decode((string) $response->getBody(), true)['access_token'];

        echo($token);
        /*$refresh_token = json_decode((string) $response->getBody(), true)['refresh_token'];
        $expires_in = json_decode((string) $response->getBody(), true)['expires_in'];
        $expires_at = Carbon::now()->addSeconds($expires_in);

        if ($token && $refresh_token) {

            $encyptedToken = Crypt::encrypt($token);
            $encyptedRefresh = Crypt::encrypt($refresh_token);
            
            $mondayToken = new MondayToken();
            $mondayToken->access_token = $encyptedToken;
            $mondayToken->refresh_token = $encyptedRefresh;
            $mondayToken->expires_at = $expires_at;
            $mondayToken->save();

            echo 'Success: Access token obtained.';
        } else {
            echo 'Error: Failed to obtain access token.';
        }*/
        
    }
}
