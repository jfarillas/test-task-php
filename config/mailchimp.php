<?php
declare(strict_types=1);

return [
    'apikey' => \env('MAILCHIMP_API_KEY', getenv('MAILCHIMP_API_KEY')),
    'server_prefix' => \env('MAILCHIMP_SERVER_PREFIX', getenv('MAILCHIMP_SERVER_PREFIX'))
];
