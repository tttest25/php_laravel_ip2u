<?php

namespace App\Auth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Auth\UserProvider;
use \Illuminate\Contracts\Auth\Authenticatable;

class CspUserGuard extends SessionGuard implements Guard

{
  public $csp;
  public $secretProperty;

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []){

        return true;
    }




/**
 * csp check
 *
 * Undocumented function long description
 *
 * @param Type $var Description
 * @return type
 * @throws conditon
 **/
public function retrieveCSPbyAPI(array $credentials = [])
{
    debug('CspCheck - Start users check');
    try {
        $text = $credentials["cryptotext"];
        start_measure('cryptoproService', 'CryptoProService');
        //$response = Http::get('172.31.23.189:8095/healthcheck');
        $response = Http::withBody(
            $text,
            'application/x-www-form-urlencoded'
        )->timeout(10)->post('http://cryptopro:8080/verify')->throw()->json();

        stop_measure('cryptoproService');
        $cspStatus = $response["status"];
        $cspSerilNum = $response["signers"][0]["serialNumber"];

        debug('CspCheck - Get from csp service ', $cspStatus, $cspSerilNum);

        $userId = DB::table('cspusers')->where('serialNumber', $cspSerilNum)->first()->userid;

        debug('CspCheck - Get result in DB', $userId);

        if ($userId > 0) {
            //$loggedInUser = Auth::loginUsingId(1, $remember = true);
            //Auth::login($loggedInUser, $remember = true);
            return true;
        }
        return false;
    } catch (\Illuminate\Http\Client\RequestException $th) {
        try {
            \Debugbar::addThrowable($th);
            stop_measure('CspCheck');
            debug('CspCheck - CSP ERROR');
            $a = $th->response->json();
            $cspStatus = $a["status"];
            $csperrMsg = $a["errMsg"]; // {$cspStatus} {$csperrMsg}
            debug($a);
            return false;
        } catch (\Throwable $th) {
            \Debugbar::addThrowable($th);
            return false;
        }
    } catch (\Throwable $th) {
        debug($th);
        \Debugbar::addThrowable($th);

       return false;
    }
}


    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool  $remember
     * @return bool
     */

    public function attempt(array $credentials = [], $remember = false)
    {
        $this->fireAttemptEvent($credentials, $remember);

        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        // If an implementation of UserInterface was returned, we'll ask the provider
        // to validate the user against the given credentials, and if they are in
        // fact valid we'll log the users into the application and return true.
        if ($this->hasValidCredentials($user, $credentials)) {
            $this->login($user, $remember);

            return true;
        }

        // If the authentication attempt fails we will fire an event so that the user
        // may be notified of any suspicious attempts to access their account from
        // an unrecognized user. A developer may listen to this event as needed.
        $this->fireFailedEvent($user, $credentials);

        return false;
    }



}

