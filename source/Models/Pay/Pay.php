<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/02/2022
 * Time: 10:36
 */

namespace Source\Models\Pay;


use Source\Models\Auth;
use Source\Support\Log;
use Source\Support\Message;

abstract class Pay
{

    protected $log;
    protected $message;
    protected $service;
    protected $apiKeyPub;
    protected $apiKeyPri;
    protected $endpoint;
    protected $callback;
    protected $build;
    protected $user;

    public function __construct()
    {
        $this->service = "https://api.pagar.me/core/v5";
        if(CONF_PAY_SANDBOX){
            $this->apiKeyPub = CONF_PAY_KEY_PUB_SANDBOX;
            $this->apiKeyPri = CONF_PAY_KEY_SECRET_SANDBOX;
        }else{
            $this->apiKeyPub = CONF_PAY_KEY_PUB_PROD;
            $this->apiKeyPri = CONF_PAY_KEY_SECRET_PROD;
        }

        $this->user = Auth::user();
        $this->log = (new Log());
        $this->message = (new Message());
    }

    public function post()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->service.$this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($this->build),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode($this->apiKeyPri.":")
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            (new Log())->telegram()->emergency($err);
            return null;
        } else {
            return $this->callback = (object) json_decode($response, true);
        }
    }

    public function get()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->service.$this->endpoint."?".http_build_query($this->build),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode($this->apiKeyPri.":")
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            (new Log())->telegram()->emergency($err);
            return null;
        } else {
            return $this->callback = (object) json_decode($response, true);
        }
    }

    public function put()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->service.$this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($this->build),
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode($this->apiKeyPri.":")
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            (new Log())->telegram()->emergency($err);
            return null;
        } else {
            return $this->callback = (object) json_decode($response, true);
        }
    }

    public function delete()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->service.$this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($this->build),
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode($this->apiKeyPri.":")
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            (new Log())->telegram()->emergency($err);
            return null;
        } else {
            return $this->callback = (object) json_decode($response, true);
        }
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }

    protected function clear($number): ?string
    {
        if(!empty($number)){
            return preg_replace("/[^0-9]/", "", $number);
        }
        return null;
    }
}