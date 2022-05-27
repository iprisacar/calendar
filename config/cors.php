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

    'supportsCredentials' => true,
    'allowedOrigins' => env('CORS_ALLOWED_ORIGINS') ? explode(',', env('CORS_ALLOWED_ORIGINS')) : ['*'],
    'allowedHeaders' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => [],
    'maxAge' => 864000,

];
