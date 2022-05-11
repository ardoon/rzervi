<?php

namespace App\Services;

use phpDocumentor\Reflection\Types\This;

class Sms
{
    private $receptor;
    private $template;
    private $params;
    private $apiKey;

    /**
     * @param string $receptor
     * @param string $template
     * @param array $params
     */
    public function __construct(string $receptor, string $template, array $params)
    {
        $this->receptor = $receptor;
        $this->template = $template;

        $parameters = '';
        foreach ($params as $key=>$param) {
            $parameters .= '&param' . ++$key . '=' . $param;
        }

        $this->params = $parameters;

        $this->apiKey = env('GHASEDAKSMS_API_KEY');

    }

    public function send()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.ghasedaksms.com/v2/send/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'receptor=' . $this->receptor . '&type=1&template=' . $this->template . $this->params,
            CURLOPT_HTTPHEADER => array(
                'apikey: QXPNdUrVu/rBlZXNLGXRplto46i7Rj1tPoxZkjhQFWg',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }


}
