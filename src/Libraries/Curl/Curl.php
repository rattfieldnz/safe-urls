<?php

namespace RattfieldNz\SafeUrls\Libraries\Curl;

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
    private $_ch;
    private $_postUrl;
    private $_headers;
    private $_payload;
    private $_defaultHeaders;
    private $_timeout;

    private $_data;
    private $_decodedData;
    private $_responseCode;

    /**
     * Curl constructor.
     *
     * Set the needed properties to do a CURL request.
     *
     * @param string $postUrl URL to use for request.
     * @param array  $headers Headers to use for request. @see setDefaultHeaders().
     * @param array  $payload Data to be submitted with CURL request.
     * @param int    $timeout Timeout in seconds to complete a CURL request. Default is 10.
     */
    public function __construct(string $postUrl, array $headers, array $payload, int $timeout = 10)
    {
        $this->_ch = curl_init();
        $this->_postUrl = $postUrl;
        $this->_headers = $headers;
        $this->_payload = $payload;
        $this->_timeout = $timeout;
        self::_setDefaultHeaders();

        $this->_data = null;
        $this->_decodedData = null;
        $this->_responseCode = null;
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

    /**
     * Execute a CURL request, and return current object for further processing.
     *
     * @return $this
     */
    public function execute()
    {
        return $this;
    }

    /**
     * Get the data retrieved from executing CURL request.
     *
     * @see \RattfieldNz\SafeUrls\Libraries\Curl\Curl->execute().
     *
     * @return array Retrieved data from CURL request.
     */
    public function getData()
    {
        return [];
    }

    /**
     * Decodes a string of JSON decoded data.
     *
     * @param string $jsonData The JSON date to be decoded.
     *
     * @return mixed|null Decoded JSON data.
     */
    private function _decode(string $jsonData)
    {
        return !empty($jsonData) ? json_decode($jsonData, true) : null;
    }

    /**
     * Sets options of current object's CURL session handle.
     *
     * @return void
     */
    private function _set(): void
    {
    }
}
