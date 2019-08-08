<?php

namespace RattfieldNz\SafeUrls\Libraries\Curl;

use Curl\Curl as PhpCurl;
use RattfieldNz\SafeUrls\Libraries\Data\Data;

/**
 * Class Curl.
 *
 * @category PHP
 *
 * @author  Rob Attfield <emailme@robertattfield.com>
 * @license https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 *
 * @link https://github.com/rattfieldnz/safe-urls/
 */
class Curl
{
    private $_payload;
    private $_defaultHeaders;
    private $_timeout;
    private $_curl;

    /**
     * Curl constructor.
     *
     * Set the needed properties to do a CURL request.
     *
     * @param  array $payload Data to be submitted with CURL request.
     * @param  int   $timeout Timeout in seconds to complete a CURL request. Default is 10.
     * @throws \ErrorException Will throw an exception if PHP ext-curl is not installed.
     */
    public function __construct(array $payload, int $timeout = 10)
    {
        if (!extension_loaded('curl')) {
            throw new \ErrorException(
                'The cURL extensions is not loaded, make sure you have installed the cURL extension: https://php.net/manual/curl.setup.php'
            );
        }

        $this->_curl = new PhpCurl();
        $this->_payload = $payload;
        $this->_timeout = $timeout;
        self::_setDefaultHeaders();
    }

    /**
     * Execute a CURL request, and return current object for further processing.
     *
     * @return PhpCurl
     */
    public function execute(): PhpCurl
    {
        $this->_curl->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->_curl->setOpt(CURLOPT_CONNECTTIMEOUT, $this->_timeout);
        $this->_curl->setOpt(CURLOPT_HTTPHEADER, $this->_defaultHeaders);
        $this->_curl->setOpt(CURLOPT_POSTFIELDS, json_encode($this->_payload));
        $this->_curl->post(Data::googleApiUrl());

        return $this->_curl;
    }

    /**
     * Get the data retrieved from executing CURL request, in JSON format.
     *
     * @return string
     *
     * @see \RattfieldNz\SafeUrls\Libraries\Curl\Curl->execute().
     */
    public function getData()
    {
        $dataObject = $this->execute();
        $data = [
            'status'   => $dataObject->getHttpStatus(),
            'response' => json_decode($dataObject->response, true),
        ];

        return json_encode($data);
    }

    /**
     * Sets the default headers to use for CURL request.
     *
     * @return void
     */
    private function _setDefaultHeaders(): void
    {
        $this->_defaultHeaders = [
            'Content-Type: application/json',
            'Connection: Keep-Alive',
        ];
    }
}
