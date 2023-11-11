<?php

namespace app\clients;

use app\core\Application;
use app\exceptions\InternalServerErrorException;
use SoapClient;

class SoapApi
{
    private SoapClient $soapClient;

    /**
     * @throws \SoapFault
     */
    public function __construct() {
        $baseUrl = Application::$config['SOAP_BASE_URL'];
        $headers = array(
            "http" => array(
                "header" => "x-api-key: " . Application::$config['PHP_API_KEY']
            )
        );

        $this->soapClient = new SoapClient($baseUrl . "/subscription?wsdl", array (
            'stream_context' => stream_context_create($headers)
        ));
    }

    /**
     * @throws \SoapFault
     * @throws InternalServerErrorException
     */
    public function createSubscription($curatorUsername, $subscriberUsername) {
        try {
           $this->soapClient->__soapCall('add', array(
                "SubscriptionData" => [
                    "curatorUsername" => $curatorUsername,
                    "subscriberUsername" => $subscriberUsername,
                    "status" => 'PENDING'
                ]
            ));
        } catch (\Exception $err) {
            throw new InternalServerErrorException();
        }

    }
}