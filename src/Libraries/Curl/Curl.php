<?php

namespace RattfieldNz\SafeUrls\Libraries\Curl;

/**
 * Class Curl.
 *
 * @author  Rob Attfield <emailme@robertattfield.com> <https://github.com/rattfieldnz>
 */
class Curl
{
    private $ch;
    private $postUrl;
    private $headers;
    private $payload;
    private $defaultHeaders;
    private $timeout;

    private $data;
    private $decodedData;
    private $responseCode;

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
        $this->ch = curl_init();
        $this->postUrl = $postUrl;
        $this->headers = $headers;
        $this->payload = $payload;
        $this->timeout = $timeout;
        self::setDefaultHeaders();

        $this->data = null;
        $this->decodedData = null;
        $this->responseCode = null;
    }

    /**
     * Sets the default headers to use for CURL request.
     */
    private function setDefaultHeaders(): void
    {
        $this->defaultHeaders = [
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
     * @see    \RattfieldNz\SafeUrls\Libraries\Curl\Curl->execute().
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
     * @param string $jsonData
     *
     * @return mixed|null Decoded JSON data.
     */
    private function decode(string $jsonData)
    {
        return !empty($jsonData) ? json_decode($jsonData, true) : null;
    }

    /**
     * Sets options of current object's CURL session handle.
     */
    private function set(): void
    {
    }
}
