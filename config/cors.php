<?php

return [
    'paths' => ['api/*'],  // should match your API route prefix
    'allowed_methods' => ['*'],  // allow all HTTP methods
    'allowed_origins' => ['https://mrservice.jp'],  // frontend domain exactly
    'allowed_headers' => ['*'],  // allow all headers
    'supports_credentials' => false,
];

