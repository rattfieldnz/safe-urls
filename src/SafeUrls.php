<?php

namespace RattfieldNz\SafeUrls;

use RattfieldNz\SafeUrls\Libraries\Curl\Curl;
use RattfieldNz\SafeUrls\Libraries\Data\Data;
use RattfieldNz\SafeUrls\Libraries\Traits\StaticCalling;

/**
 * Class SafeUrlsFacade.
 *
 * The main class used for the SafeUrlsFacade package.
 *
 * @category  PHP
 *
 * @author Rob Attfield <emailme@robertattfield.com>
 * @license https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 *
 * @link https://github.com/rattfieldnz/safe-urls/
 */
class SafeUrls
{
    use StaticCalling;

    /**
     * @var array Variable to hold list of urls to check.
     */
    private $urls;

    private $results;

    /**
     * SafeUrlsFacade constructor.
     */
    public function __construct()
    {
        // Initialise the list of urls as an empty array.
        $this->urls = [];

        // Initialise the list of urls as an empty JSON string.
        $this->results = '';
    }

    /**
     * Checks a given set of URLs with Google's Safe Browsing API.
     *
     * @param array $urls           An array of URLs to check.
     * @param bool  $resultsAsArray Determines whether results will be returned as array or JSON.
     *
     * @throws \ErrorException
     *
     * @return string|array The set of results, in JSON.
     */
    public static function check(array $urls, bool $resultsAsArray = false)
    {
        $payload = Data::payload($urls);

        $data = (new Curl($payload))->getData();

        return $resultsAsArray === false ? $data : json_decode($data, true);
    }

    /**
     * Function used to test 'check' static method with mocks in PHPUnit.
     *
     * @param array $urls An array of URLs to check.
     *
     * @return array|string The set of results, in JSON.
     */
    public function checkCallStatic(array $urls)
    {
        return $this->callStatic(self::class, 'check', $urls);
    }

    public function execute()
    {
        $this->results = self::check($this->urls);

        return $this;
    }

    /**
     * Add URLs to existing list for checking.
     *
     * @param array $urls An array of URLs to add.
     *
     * @return SafeUrls
     */
    public function add(array $urls): self
    {
        $this->urls = array_merge($this->urls, $urls);

        return $this;
    }

    /**
     * Remove URLs from existing list.
     *
     * @param array $urls An array of URLs to remove.
     *
     * @return SafeUrls
     */
    public function remove(array $urls): self
    {
        $this->urls = array_values(array_diff($this->urls, $urls));

        return $this;
    }

    /**
     * Get the URLs currently saved.
     *
     * @param bool $asArray Determines whether results to be returned as array or JSON.
     *
     * @return array|string
     */
    public function getCurrentUrls(bool $asArray = false)
    {
        return $asArray === false ? json_encode($this->urls) : $this->urls;
    }

    public function getResults()
    {
        return $this->results;
    }

    /**
     * Check to see if the URL has been marked as unsafe.
     *
     * @param string $url       The URL to check.
     * @param string $resultSet An existing set of JSON results
     *                          to pass in as a parameter.
     *
     * @return bool True if the URL is unsafe, and false if
     *              it is safe,
     */
    public function isDangerous(string $url, string $resultSet = ''): bool
    {
        // Since Google API seems to not be working (even showing unsafe sites as 'safe'),
        // Below is a set of results retrieved via Postman.
        // See tests\Libraries\Curl\CurlTest testMalwareSocialEngineeringAnyPlatformUrl().
        //$this->results = '{ "status": 200, "response": { "matches": [ { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/phishing.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/malware.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" } ] } }';
        //$data = json_decode($this->results);

        $data = !empty($resultSet) ? $resultSet : $this->results;

        $data = json_decode($data);
        $response = empty($data->response) ? null : $data->response;

        if (empty($response)) {
            return false;
        }

        if (isset($response->matches)) {
            foreach ($response->matches as $result) {
                if ($result->threat->url == $url) {
                    return true;
                }
            }
        }

        return false;
    }
}
