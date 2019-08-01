<?php

namespace RattfieldNz\SafeUrls;

/**
 * Class SafeUrls
 *
 * The main class used for the SafeUrls package.
 *
 * @author Rob Attfield <emailme@robertattfield.com> <https://github.com/rattfieldnz>
 * @package RattfieldNz\SafeUrls
 */
class SafeUrls
{
    /**
     * @var array $urls Variable to hold list of urls to check.
     */
    private $urls;

    /**
     * SafeUrls constructor.
     */
    public function __construct()
    {
        // Initialise the list of urls as an empty array.
        $this->urls = [];
    }
}
