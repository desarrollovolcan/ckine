<?php
$baseUrl = getenv('APP_BASE_URL');
if (!$baseUrl) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $baseDir = rtrim(str_replace('/public', '', dirname($scriptName)), '/');
    $baseUrl = $baseDir === '' ? '/' : $baseDir . '/';
}
return [
    'name' => 'Centro Kinésico',
    'base_url' => $baseUrl,
    'timezone' => getenv('APP_TIMEZONE') ?: 'America/Santiago',
    'public_portal_enabled' => getenv('PUBLIC_PORTAL_ENABLED') ? filter_var(getenv('PUBLIC_PORTAL_ENABLED'), FILTER_VALIDATE_BOOL) : true,
];
