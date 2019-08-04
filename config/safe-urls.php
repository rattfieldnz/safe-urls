<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Safebrowsing Configuration
    |--------------------------------------------------------------------------
    | Many of these entries can be left as default unless you want something different, however
    | the Google Safebrowsing key is required.
    |
    | IMPORTANT: Google Safebrowsing free tier is throttled. You can view your current API
    | limits here: https://console.cloud.google.com/apis/api/safebrowsing.googleapis.com/quotas?project=rattfieldnz-safeurls
    |
    | For more information on options:
    |
    | Platform Type: https://developers.google.com/safe-browsing/v4/reference/rest/v4/PlatformType
    | Threat Types: https://developers.google.com/safe-browsing/v4/reference/rest/v4/ThreatType
    | Threat Entry Types: https://developers.google.com/safe-browsing/v4/reference/rest/v4/ThreatEntryType
    |
    | Sourced from: https://github.com/snipe/Safebrowsing/blob/master/src/Config/safebrowsing.php.
    */
    'google' => [
        'api_key'      => env('GOOGLE_API_KEY'),
        'timeout'      => env('GOOGLE_CURL_TIMEOUT'),
        'threat_types' => [
            'THREAT_TYPE_UNSPECIFIED',
            'MALWARE',
            'SOCIAL_ENGINEERING',
            'UNWANTED_SOFTWARE',
            'POTENTIALLY_HARMFUL_APPLICATION',
        ],
        'threat_entry_types' => [
            'URL',
            'THREAT_ENTRY_TYPE_UNSPECIFIED',
        ],
        'threat_platform_types' => [
            'PLATFORM_TYPE_UNSPECIFIED',
            'WINDOWS',
            'LINUX',
            'ANDROID',
            'OSX',
            'IOS',
            'ANY_PLATFORM',
            'ALL_PLATFORMS',
            'CHROME',
        ],
        'clientId'      => env('GOOGLE_CLIENT_ID'),
        'clientVersion' => env('GOOGLE_CLIENT_VERSION'),
    ],
];
