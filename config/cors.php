<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */


    //This code snippet appears to be part of a configuration file for Cross-Origin Resource Sharing (CORS) in a Laravel application

    'paths' => ['api/*', 'sanctum/csrf-cookie'], //api/*: Apply CORS to all routes starting with api/...sanctum/csrf-cookie: Apply CORS to the Sanctum CSRF cookie endpoint, which is used for authentication.

    'allowed_methods' => ['*'],   // This specifies which HTTP methods are allowed for CORS requests.['*']: All HTTP methods (GET, POST, PUT, DELETE, etc.) are allowed.

    'allowed_origins' => ['*'], //This specifies which origins are allowed to make CORS requests.['*']: Any origin is allowed. This means any website can make requests to your API.

    'allowed_origins_patterns' => [], //This specifies patterns for origins that are allowed to make CORS requests.[]: No specific patterns are set, so only the allowed_origins configuration is used.

    'allowed_headers' => ['*'], // This specifies which HTTP headers can be used in CORS requests.['*']: Any header is allowed. This includes standard headers like Content-Type, Authorization, etc.

    'exposed_headers' => [], //This specifies which headers are exposed to the browser.[]: No headers are explicitly exposed. By default, only a limited set of headers is accessible to JavaScript in the browser.

    'max_age' => 0, // This specifies whether user credentials (like cookies, HTTP authentication) can be included in CORS requests.true: Credentials are supported. This means cookies and HTTP authentication information will be included in requests.

    'supports_credentials' => true,

];
