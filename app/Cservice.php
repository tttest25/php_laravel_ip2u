<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;



class Cservice
{

/** @var string $urlService url for cryptoproservice from config with health check */
protected $urlService = null;

/** @var bool $status cryptoservice ok */
protected $status = false;

    public function __construct(string $urlService)
    {

        $this->urlService=$urlService;

    }

    /**
     * function check healt
     *
     * check healt of cryptopro microsrvice
     *
     *
     * @return type
     * @throws conditon
     **/
    public function checkHealth()
    {
        $url = $this->urlService."/healthcheck";
        $response = Http::timeout(3)->get($url)->throw()->json();

        dd($response);
    }

    public function getStatus()
    {
        return ["url" => $this->urlService,"status" => $this->status];
    }

    /**
     * check detached sign in base 64
     *
     * cspservice -> verifyd -> sSignedMessage, dataInBase64
     *
     * @param string $dataInBase64 signed data
     * @param string $sSignedMessage signed data
     *
     * @return array
     * @throws conditon
     **/
    public function verifyD(string $dataInBase64, string $sSignedMessage)
    {
      try {
        $url = $this->urlService."verifyd";

        $response = Http::timeout(5)
        ->attach('sSignedMessage', $sSignedMessage, 'sign.b64')
        ->attach('dataInBase64'  , $dataInBase64  , 'datain.b64' )
        ->post($url)
        // ->throw()
        ->json();

        return  $response;

      }  catch (\Illuminate\Http\Client\RequestException $th) {
            Log::error(__CLASS__." - Cservise - VerifyD - CSP ERROR ${th}");
            return serialize($th);
        }
   }
}

