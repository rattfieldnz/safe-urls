# safe-urls

[![PHP Version](https://img.shields.io/badge/php-7.3%2B-green.svg)](https://packagist.org/packages/rattfieldnz/safe-urls) [![PHP Version](https://img.shields.io/badge/php-7.2%2B-green.svg)](https://packagist.org/packages/rattfieldnz/safe-urls) 
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci] 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rattfieldnz/safe-urls/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rattfieldnz/safe-urls/?branch=master) 
[![codecov](https://codecov.io/gh/rattfieldnz/safe-urls/branch/master/graph/badge.svg)](https://codecov.io/gh/rattfieldnz/safe-urls)

A Laravel package to check URLs with [Google's Safe Browsing API (look up)](https://developers.google.com/safe-browsing/v4/lookup-api). 

Inspired by another similar package @ [https://github.com/snipe/Safebrowsing](https://github.com/snipe/Safebrowsing).

Take a look at [contributing.md](contributing.md) to see a to do list.

<hr/>

* [Installation](#installation)
  * [Update Config](#update_config)
  * [Publish Config](#publish_config)
  * [Set Your Google Safebrowsing API Key](#set_google_safebrowsing_key)
* [Usage](#usage)
  * [Using Blade Syntax](#usage_blade)
  * [Using Facades](#usage_facades)
* [Example With Input and Output](#example_with_input_and_output)
* [Test URLs](#testing_urls)
* [Testing](#testing)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

<hr/>

## Please Note:
__This package requires that you have [an active Google Safebrowsing API key](https://developers.google.com/safe-browsing/v4/get-started). It absolutely will not work without one.__ It's free to create an API key .

Google also throttles API usage, so if you have a high-traffic site, you may want to build in a caching layer or something so you don't burn through your requests too quickly. You can keep an eye on your usage through the [Google API console](https://console.developers.google.com/apis/api/safebrowsing.googleapis.com/usage).

__This project is not ready for use in production yet. When it is, there will be first major release (i.e. 1.0.0).__

## <a id="installation"></a>Installation

Via Composer

``` bash
$ composer require rattfieldnz/safe-urls
```
### <a id="update_config"></a>Update Your Config

#### For applications using Laravel =< 5.4

Open `config/app.php` and add:

``` php
RattfieldNz\SafeUrls\SafeUrlsServiceProvider::class,
```

to your `providers` array in `config/app.php`, and:

``` php
'SafeUrls' => RattfieldNz\SafeUrls\Facades\SafeUrlsFacade::class,
```

to your `aliases` array in `config/app.php`.

### <a id="publish_config"></a>Publish the config

``` bash
php artisan vendor:publish
```

This will add a `safe-urls.php` config file into your project's `config` folder.

### <a id="set_google_safebrowsing_key"></a>Set Your Google Safebrowsing API Key

In your `.env`, add:

``` bash
GOOGLE_API_KEY=YOUR-ACTUAL-API-KEY
```

There are additional options in the config file that relate to what specific types of threats you want to check for, and what platforms you want to check on, but you only really need to worry about that if you want to check *fewer* things, as it's pretty inclusive already.

## <a id="usage"></a>Usage

### <a id="usage_blade"></a>Using Blade Syntax

```php
@if(isset(SafeUrls::check($urls, true)["response"]["matches"]))
    <p>There are {{ count(SafeUrls::check($urls, true)["response"]["matches"]) }} dangerous URLs.</p>
@else
    <p>No results were found</p>
@endif
```

Where `$urls` could be an array of URLs to check, perhaps [passed through your Controller to a view](https://laravel.com/docs/5.8/views#passing-data-to-views).

Where `true` will return the results as an associative array. 

`false` (or not having the second parameter) will return the results as a JSON-encoded string.

``` php
@if (SafeUrls::isDangerous('http://twitter.com/'))
    // do something if the url is flagged as suspicious
@else
    // hooray - it's not flagged!
@endif
```

### <a id="usage_facades"></a>Using Facades
``` php
SafeUrls::add(['http://ianfette.org']);
SafeUrls::add(['http://malware.testing.google.test/testing/malware/']);
SafeUrls::execute();
print('Status of the third URL is: '.SafeUrls::isDangerous('http://twitter.com/'));
```

## <a id="example_with_input_and_output"></a>Example with input and output

If the value of `$urls` was:

```php
$urls = [
    'http://www.yahoo.com/'
    'http://www.google.com/'
    'http://malware.testing.google.test/testing/malware/'
    'http://twitter.com/'
    'http://ianfette.org'
    'https://github.com/'
    'https://testsafebrowsing.appspot.com/s/phishing.html'
    'https://testsafebrowsing.appspot.com/s/malware.html'
    'http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/'
    'http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/'
];   
```

`SafeUrls::check($urls, true)` Would return the following associative array:

```php
[
    "status" => 200,
    "response" => 
        [
            "matches" => [
                [
                    "threatType" => "MALWARE",
                    "platformType" => "ANY_PLATFORM",
                    "threat" => [
                        "url" => "http://malware.testing.google.test/testing/malware/"
                    ],
                    "cacheDuration" => "300s",
                    "threatEntryType" => "URL"
                ],
                [
                    "threatType" => "SOCIAL_ENGINEERING",
                    "platformType" => "ANY_PLATFORM",
                    "threat" => [
                        "url" => "http://malware.testing.google.test/testing/malware/"
                    ],
                    "cacheDuration" => "300s",
                    "threatEntryType" => "URL"
                ],
                [
                    "threatType" => "SOCIAL_ENGINEERING",
                    "platformType" => "ANY_PLATFORM",
                    "threat" => [
                        "url" => "https://testsafebrowsing.appspot.com/s/phishing.html"
                    ],
                    "cacheDuration" => "300s",
                    "threatEntryType" => "URL"
                ],
                [
                    "threatType" => "MALWARE",
                    "platformType" => "ANY_PLATFORM",
                    "threat" => [
                        "url" => "https://testsafebrowsing.appspot.com/s/malware.html"
                    ],
                "cacheDuration" => "300s",
                "threatEntryType" => "URL"
            ],
            [
                "threatType" => "MALWARE",
                "platformType" => "ANY_PLATFORM",
                "threat" => [
                    "url" => "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/"
                ],
                "cacheDuration" => "300s",
                "threatEntryType" => "URL"
            ],
            [
                "threatType" => "SOCIAL_ENGINEERING",
                "platformType" => "ANY_PLATFORM",
                "threat" => [
                    "url" => "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/"
                ],
                "cacheDuration" => "300s",
                "threatEntryType" => "URL"
            ],
        ],
    ],
]
```

`SafeUrls::check($urls)` (or `SafeUrls::check($urls, false)`) Would return the following JSON-encoded string:

```json
{  
   "status":200,
   "response":{  
      "matches":[  
         {  
            "threatType":"MALWARE",
            "platformType":"ANY_PLATFORM",
            "threat":{  
               "url":"http:\/\/malware.testing.google.test\/testing\/malware\/"
            },
            "cacheDuration":"300s",
            "threatEntryType":"URL"
         },
         {  
            "threatType":"SOCIAL_ENGINEERING",
            "platformType":"ANY_PLATFORM",
            "threat":{  
               "url":"http:\/\/malware.testing.google.test\/testing\/malware\/"
            },
            "cacheDuration":"300s",
            "threatEntryType":"URL"
         },
         {  
            "threatType":"SOCIAL_ENGINEERING",
            "platformType":"ANY_PLATFORM",
            "threat":{  
               "url":"https:\/\/testsafebrowsing.appspot.com\/s\/phishing.html"
            },
            "cacheDuration":"300s",
            "threatEntryType":"URL"
         },
         {  
            "threatType":"MALWARE",
            "platformType":"ANY_PLATFORM",
            "threat":{  
               "url":"https:\/\/testsafebrowsing.appspot.com\/s\/malware.html"
            },
            "cacheDuration":"300s",
            "threatEntryType":"URL"
         },
         {  
            "threatType":"MALWARE",
            "platformType":"ANY_PLATFORM",
            "threat":{  
               "url":"http:\/\/testsafebrowsing.appspot.com\/apiv4\/ANY_PLATFORM\/MALWARE\/URL\/"
            },
            "cacheDuration":"300s",
            "threatEntryType":"URL"
         },
         {  
            "threatType":"SOCIAL_ENGINEERING",
            "platformType":"ANY_PLATFORM",
            "threat":{  
               "url":"http:\/\/testsafebrowsing.appspot.com\/apiv4\/ANY_PLATFORM\/SOCIAL_ENGINEERING\/URL\/"
            },
            "cacheDuration":"300s",
            "threatEntryType":"URL"
         }
      ]
   }
}
```

Both outputs will depend on what options you have set in your `config/safe-urls.php` file.

## <a id="testing_urls"></a>Test URLs

Here are some handy test urls you can use while you're experimenting with this Laravel package.

- http://www.yahoo.com/ (OK)
- http://www.google.com/ (OK)
- http://malware.testing.google.test/testing/malware/ (Malware)
- http://twitter.com/ (OK)
- http://ianfette.org (Malware)
- https://github.com/ (OK)
- https://testsafebrowsing.appspot.com/s/phishing.html (Malware)
- https://testsafebrowsing.appspot.com/s/malware.html (Malware)
- http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/ (Malware)
- http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/ (Malware / Social Engineering)

## <a id="changelog"></a>Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## <a id="testing"></a>Testing

From inside the root folder of this package:

``` bash
$ ./run_phpunit YOUR_GOOGLE_API_KEY
```
Replace YOUR_GOOGLE_API_KEY with your key. Get one by visiting [https://developers.google.com/safe-browsing/v4/get-started](https://developers.google.com/safe-browsing/v4/get-started).

## <a id="contributing"></a>Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## <a id="security"></a>Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## <a id="credits"></a>Credits

- [Rob Attfield][link-author]
- [All Contributors][link-contributors]

## <a id="license"></a>License
Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rattfieldnz/safe-urls.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rattfieldnz/safe-urls.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rattfieldnz/safe-urls/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/199432762/shield

[link-packagist]: https://packagist.org/packages/rattfieldnz/safe-urls
[link-downloads]: https://packagist.org/packages/rattfieldnz/safe-urls
[link-travis]: https://travis-ci.org/rattfieldnz/safe-urls
[link-styleci]: https://styleci.io/repos/199432762
[link-author]: https://github.com/rattfieldnz
[link-contributors]: ../../contributors
