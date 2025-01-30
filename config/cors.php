<?php

return [
    'paths' => ['api/*'], // Allow CORS for all API routes
    'allowed_methods' => ['*'], // Allow all HTTP methods
    'allowed_origins' => ['http://localhost:3000'], // Allow your Next.js frontend
    'allowed_origins_patterns' => [], // No regex patterns needed
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [], // No headers to expose
    'max_age' => 0, // No preflight caching
    'supports_credentials' => true, // Allow credentials (cookies)
];