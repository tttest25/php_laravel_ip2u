<?php

namespace App\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;


class CspUserProvider extends EloquentUserProvider implements UserProvider
{

/** @var string $csptable table for get id of user */
    protected string $csptable;

/** @var string $cspapi url for microservice api for check csp */
    protected string $cspapi;

    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct(HasherContract $hasher, $model, string $csptable, string $cspapi)
    {
        $this->model = $model;
        $this->hasher = $hasher;
        $this->csptable = $csptable;
        $this->cspapi = $cspapi;
    }


       /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {


        if (empty($credentials) ||
           (count($credentials) === 1 &&
            Str::contains($this->firstCredentialKey($credentials), 'password'))) {
            return;
        }


        $cspSerial=null;
        $userId=null;
        if (array_key_exists('cryptotext', $credentials) && is_string($credentials['cryptotext'])) {
            $cspSerial=$this->CspGetSerial($credentials["cryptotext"]);

            $DBuserid = DB::table($this->csptable)->where('serialNumber', $cspSerial)->first();

            if (! is_null($DBuserid)) {
                $userId= $DBuserid->userid;
            }
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();


        if (! is_null($userId)) {
            // if find CSP serial -> return userid
            $query->where("id", $userId);
        } else {
            foreach ($credentials as $key => $value) {
                if (Str::contains($key, 'password') || Str::contains($key, 'cryptotext')) {
                    continue;
                }

                if (is_array($value) || $value instanceof Arrayable) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        return $query->first();
    }


        /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        if (array_key_exists('cryptotext', $credentials)) {
          return true;
        }

        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }



/**
 * csp function to get serial of crypto text
 *
 * Undocumented function long description
 *
 * @param string $cryptotext cryptotext base 64 for cryptopro
 * @return string|null
 * @throws ???
 **/
public function CspGetSerial(string $cryptotext )
{
    try{
    start_measure('cryptoproService', 'CryptoProService');
        //$response = Http::get('172.31.23.189:8095/healthcheck');
        $response = Http::withBody(
            $cryptotext,
            'application/x-www-form-urlencoded'
        )->timeout(5)->post($this->cspapi)->throw()->json();

        stop_measure('cryptoproService');
        $cspStatus = $response["status"];
        $cspSerialNum = $response["signers"][0]["serialNumber"];
        Log::info(__CLASS__." - AUTH - CspGetSerial - CSP ok ${cspStatus}, ${cspSerialNum}", [static::class, Request::ip(), $cspStatus, $cspSerialNum]);



        return $cspSerialNum;
    } catch (\Illuminate\Http\Client\RequestException $th) {
        try {
            \Debugbar::addThrowable($th);
            stop_measure('CspCheck');
            debug(__CLASS__." - CspCheck - CSP ERROR");
            $a = $th->response->json();
            $cspStatus = $a["status"];
            $csperrMsg = $a["errMsg"]; // {$cspStatus} {$csperrMsg}
            $ip=Request::getClientIp();
            Log::error(__CLASS__." - AUTH - CspGetSerial - CSP ERROR ${cspStatus}, ${csperrMsg} , ${ip}");
            return null;
        } catch (\Throwable $th) {
            \Debugbar::addThrowable($th);
            Log::error($th);
            return null;
        }
    } catch (\Throwable $th) {
        debug($th);
        \Debugbar::addThrowable($th);
        Log::error($th);

       return null;
    }
}


}

