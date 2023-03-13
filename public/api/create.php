<?php 

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * PayPal integration documentation:
 * @link https://developer.paypal.com/docs/checkout/standard/integrate/
 */
class PayPalPayments
{
    private $clientId;
    private $clientSecret;
    private $baseUrl;

    public function __construct()
    {
        $this->clientId = $_ENV['PAYPAL_CLIENT_ID'];
        $this->clientSecret = $_ENV['PAYPAL_CLIENT_SECRET'];
        $this->baseUrl = $_ENV['PAYPAL_CLIENT_ENDPOINT'];
    }

    public function createOrder()
    {                       
        // @todo createorder
    }

    public function captureOrder(string $orderId)
    {
       
        // @todo order handling

        echo json_encode(["response" => "Response", "Username" => "Username"]);
        exit;
    }

    private function getAccessToken()
    {
        return $this->generateAccessToken();
    }

    private function generateAccessToken()
    {
        $client = new Client();
        $options = [
            'auth' => [
                $this->clientId,
                $this->clientSecret
            ],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ];
        $request = new Request('POST',  $this->baseUrl . '/v1/oauth2/token');
        try {
            $res = $client->sendAsync($request, $options)->wait();
        } catch (\Exception $e) {
            // @todo add logging
        }

        return json_decode($res->getBody()->getContents(), true)['access_token'];
    }
}