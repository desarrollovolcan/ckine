<?php
return [
    'name' => 'Centro Kinésico',
    'base_url' => getenv('APP_BASE_URL') ?: '/',
    'timezone' => getenv('APP_TIMEZONE') ?: 'America/Santiago',
    'public_portal_enabled' => getenv('PUBLIC_PORTAL_ENABLED') ? filter_var(getenv('PUBLIC_PORTAL_ENABLED'), FILTER_VALIDATE_BOOL) : true,
];
