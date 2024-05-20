<?php

namespace App\Libraries;

use App\Models\Raffle;
use Illuminate\Support\Facades\Http;

class Pixcred
{
    private string $endpoint;
    private string $authlogin;
    private string $authtoken;
    private string $webhook_notify;

    function __construct($params)
    {
        if(empty($params['token']) || empty($params['authlogin']) || empty($params['authtoken']) || empty($params['endpoint'])) {
            setLogErros('Libraries->Pixcred', 'Raffle_id not found code 0', $params);
            return false;
        }

        $this->authtoken = $params['authtoken'];
        $this->authlogin = $params['authlogin'];
        $this->endpoint  = $params['endpoint'];
        $this->webhook_notify = (string)config('app.url').'/webhook_pixcred';
    }

    public function pix_generate($data)
    {
        $data['url_notify'] = $this->webhook_notify;
        $router = 'cob_requests/create';
        $return = $this->send($router, 'POST', $data);

        return $return;
    }

    private function send($router = "", $method = 'POST', $data = [])
    {
        switch ($method) {
            case 'POST':
                $headers = [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json'
                ];
                $response = Http::withBasicAuth($this->authlogin,$this->authtoken)->withHeaders($headers)->post($this->endpoint . $router, $data);
                break;
            case 'GET':
                $headers = [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                ];
                $response = Http::withBasicAuth($this->authlogin,$this->authtoken)->withHeaders($headers)->get($this->endpoint . $router);
                break;
        }

        $statusCode = 0;

        if(!empty($response->status())) $statusCode = $response->status();
        //dd($response->status(), $response->json());
        if ($statusCode === 200 || $statusCode === 201 || $statusCode === 202) {
            $responseBody = $response->json();

            return $responseBody;
        } else {
            setLogErros('LIBRARIE->pixcred', 'Erro geração do pix', $response, 'catch', $statusCode);
            return false;
        }
    }
}
