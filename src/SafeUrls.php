<?php

namespace RattfieldNz\SafeUrls;

/**
 * Class SafeUrls.
 *
 * The main class used for the SafeUrls package.
 *
 * @category  PHP
 * @package   SafeUrls
 * @author Rob Attfield <emailme@robertattfield.com>
 * @license https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 * @link https://github.com/rattfieldnz/safe-urls/
 */
class SafeUrls
{
    /**
     * @var array Variable to hold list of urls to check.
     */
    private $urls;

    private $results;

    /**
     * SafeUrls constructor.
     */
    public function __construct()
    {
        // Initialise the list of urls as an empty array.
        $this->urls = [];

        // Initialise the list of urls as an empty array.
        $this->results = [];
    }

    /**
     * Checks a given set of URLs with Google's Safe Browsing API.
     *
     * @param array $urls An array of URLs to check.
     * @return string The set of results, in JSON.
     */
    public static function check(array $urls): string{
        return "";
    }

    /**
     * Add URLs to existing list for checking.
     *
     * @param array $urls An array of URLs to add.
     * @return SafeUrls
     */
    public function add(array $urls): SafeUrls{
        $this->urls = array_merge($this->urls, $urls);
        return $this;
    }

    /**
     * Remove URLs from existing list.
     *
     * @param array $urls An array of URLs to remove.
     * @return SafeUrls
     */
    public function remove(array $urls): SafeUrls{
        $this->urls = array_diff($this->urls, $urls);
        return $this;
    }

    /**
     * Check to see if the URL has been marked as unsafe.
     *
     * @param string $url The URL to check.
     * @return bool True if the URL is unsafe, and false if
     * it is safe,
     */
    public function isDangerous(string $url): bool {
        return false;
    }

    /**
     * Check to see if the URL has been marked as safe.
     *
     * @param string $url The URL to check.
     * @return bool True if the URL is safe, and false if
     * it is not safe,
     */
    public function isSafe(string $url){
        return false;
    }

    /**
     * Gets currently dangerous URLs, in JSON format.
     *
     * @return string The dangerous URLs, in JSON format.
     */
    public function getDangerous(): string {
        return "";
    }

    /**
     * Gets currently safe URLs, in JSON format.
     *
     * @return string The safe URLs, in JSON format.
     */
    public function getSafe(): string {
        return "";
    }

    /**
     * Format a given list of URLs for use with Google's
     * Safe Browsing API.
     *
     * @param array $urls
     * @return array
     */
    public static function format(array $urls): array {
        return [];
    }
}
