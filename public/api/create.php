<?php

/**
 * Create.php
 *
 * Creates orders in the Paypal backend
 *
 * PHP version 8
 *
 * @category Create_Class
 * @package  Create_Class
 * @author   James D <james.dodd@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * @link     http://localhost:82/
 */

namespace public\api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * PayPal integration documentation:
 *
 * @category Create_Class
 * @package  Create_Class
 * @author   James D <james.dodd@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * @link     https://developer.paypal.com/docs/checkout/standard/integrate/
 */
class PayPalPayments
{
    private $_clientId;
    private $_clientSecret;
    private $_baseUrl;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->_clientId = $_ENV['PAYPAL_CLIENT_ID'];
        $this->_clientSecret = $_ENV['PAYPAL_CLIENT_SECRET'];
        $this->_baseUrl = $_ENV['PAYPAL_CLIENT_ENDPOINT'];
    }

    /**
     * Creates the order
     *
     * @return void
     */
    public function createOrder()
    {
        // @todo createorder
    }

    /**
     * Captures the order once it's created
     *
     * @param string $orderId The ID for the order
     *
     * @return void
     */
    public function captureOrder(string $orderId)
    {

        // @todo order handling

        echo json_encode(["response" => "Response", "Username" => "Username"]);
        exit;
    }

    /**
     * Returns the JWT generated by generateAccessToken
     *
     * @return string
     */
    private function getAccessToken()
    {
        return $this->generateAccessToken();
    }

    /**
     * Generates a JWT
     *
     * @return void
     */
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
        $request = new Request('POST', $this->baseUrl . '/v1/oauth2/token');
        try {
            $res = $client->sendAsync($request, $options)->wait();
        } catch (\Exception $e) {
            // @todo add logging
        }

        return json_decode($res->getBody()->getContents(), true)['access_token'];
    }
}
