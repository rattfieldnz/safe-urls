<?php

namespace RattfieldNz\SafeUrls\Libraries\Curl;

use Curl\Curl as PhpCurl;
use RattfieldNz\SafeUrls\Libraries\Config\Config;

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
    private $_postUrl;
    private $_payload;
    private $_defaultHeaders;
    private $_timeout;
    private $_curl;

    /**
     * Curl constructor.
     *
     * Set the needed properties to do a CURL request.
     *
     * @param string $postUrl URL to use for request.
     * @param array  $payload Data to be submitted with CURL request.
     * @param int    $timeout Timeout in seconds to complete a CURL request. Default is 10.
     *
     * @throws \ErrorException
     */
    public function __construct(string $postUrl, array $payload, int $timeout = 10)
    {
        $this->_curl = new PhpCurl();
        $this->_postUrl = $postUrl;
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
        $this->_curl->post($this->_postUrl);
        return $this->_curl;
    }

    /**
     * Get the data retrieved from executing CURL request.
     *
     * @return array|string
     * @see    \RattfieldNz\SafeUrls\Libraries\Curl\Curl->execute().
     */
    public function getData()
    {
        $dataObject = $this->execute();
        $data = [
            'status' => $dataObject->getHttpStatus(),
            'response' => json_decode($dataObject->response, true)
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
