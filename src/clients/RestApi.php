<?php

namespace app\clients;

use app\core\Application;
use app\exceptions\BadRequestException;
use app\exceptions\BaseException;
use app\exceptions\InternalServerErrorException;
use app\exceptions\UnauthorizedException;

class RestApi
{
    private $ch;
    private $baseUrl;
    public function __construct() {
        $this->ch = curl_init();

        // Set common options in the constructor
        $this->baseUrl = Application::$config['REST_API_URL'];
        $apiKey = Application::$config['REST_API_KEY'];
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $apiKey]);
    }

    /**
     * @throws BaseException
     * @throws BadRequestException
     */
    public function getCurators($options) {
        $path = $this->baseUrl . '/curator';
        if (isset($options['take']) && isset($options['page'])) {
            $path .= '?page=' . $options['page'] . '&take=' . $options['take'];
        }
        curl_setopt($this->ch, CURLOPT_URL, $path);

        return $this->executeGet($path);
    }

    public function __destruct() {
        curl_close($this->ch);
    }

    /**
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws InternalServerErrorException
     * @throws BaseException
     */
    public function executeGet(string $path) {
        curl_setopt($this->ch, CURLOPT_URL, $path);

        $response = curl_exec($this->ch);
        if (curl_errno($this->ch)) {
            throw new InternalServerErrorException(true);
        }

        $res = $this->getDecodedResponse($response);
        $this->handleErrors($res);
        return $res['data'];
    }

    private function getDecodedResponse($response) {
        $decodedResponse = json_decode($response, true);

        if ($decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON decoding error: ' . json_last_error_msg();
        }

        // Handle $decodedResponse as needed
        return $decodedResponse;
    }

    /**
     * @throws UnauthorizedException
     * @throws BaseException
     * @throws BadRequestException
     */
    private function handleErrors($response) {
        $httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            return;
        }
        if ($httpCode == 400) {
            throw new BadRequestException();
        }
        if ($httpCode == 401) {
            throw new UnauthorizedException();
        }
        throw new BaseException($httpCode, $response['message'], true);
    }

    public function getCuratorDetails(string $curatorUsername, string $status)
    {
        $path = $this->baseUrl . '/curator/' . $curatorUsername . '?';
        if (isset($options['take']) && isset($options['page'])) {
            $path .= 'page=' . $options['page'] . '&take=' . $options['take'];
        }
        if ($status == 'ACCEPTED') {
            $path .= '&reviews=true';
        }
        curl_setopt($this->ch, CURLOPT_URL, $path);

        return $this->executeGet($path);
    }
}