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

## Please Note:
__This package requires that you have [an active Google Safebrowsing API key](https://developers.google.com/safe-browsing/v4/get-started). It absolutely will not work without one.__ It's free to create an API key .

Google also throttles API usage, so if you have a high-traffic site, you may want to build in a caching layer or something so you don't burn through your requests too quickly. You can keep an eye on your usage through the [Google API console](https://console.developers.google.com/apis/api/safebrowsing.googleapis.com/usage).

__This project is not ready for use in production yet. When it is, there will be first major release (i.e. 1.0.0).__

## Installation

Via Composer

``` bash
$ composer require rattfieldnz/safe-urls
```
### Update Your Config

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

### Publish the config

``` bash
php artisan vendor:publish
```

### Set Your Google Safebrowsing API Key

In your `.env`, add:

``` bash
GOOGLE_API_KEY=YOUR-ACTUAL-API-KEY
```

There are additional options in the config file that relate to what specific types of threats you want to check for, and what platforms you want to check on, but you only really need to worry about that if you want to check *fewer* things, as it's pretty inclusive already.

## Usage

### Using Blade Syntax

``` php
{{ SafeUrls::check($urls, true) }}
```

Where `true` will return the results as an associative array. 

`false` (or not having the second parameter) will return the results as a JSON-encoded string.

or

``` php
@if (SafeUrls::isDangerous('http://twitter.com/'))
    // do something if the url is flagged as suspicious
@else
    // hooray - it's not flagged!
@endif
```

where `$urls` is an array of URLs that you would like to check against the Google Safebrowsing API.

### Using Facades
``` php
SafeUrls::add(['http://ianfette.org']);
SafeUrls::add(['http://malware.testing.google.test/testing/malware/']);
SafeUrls::execute();
print('Status of the third URL is: '.SafeUrls::isDangerous('http://twitter.com/'));
```

## Test URLs

Here are some handy test urls you can use while you're experimenting with the system.

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

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

From inside the root folder of this package:

``` bash
$ ./run_phpunit YOUR_GOOGLE_API_KEY
```
Replace YOUR_GOOGLE_API_KEY with your key. Get one by visiting [https://developers.google.com/safe-browsing/v4/get-started](https://developers.google.com/safe-browsing/v4/get-started).

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Rob Attfield][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

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
