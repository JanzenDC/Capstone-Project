<?php
/**
 * Test file to verify .env is being loaded correctly
 * Access this file via browser to see if .env is being read
 * DELETE THIS FILE AFTER TESTING
 */

require_once(__DIR__ . '/config.php');

header('Content-Type: application/json');

$result = [
    'env_file_exists' => file_exists(__DIR__ . '/../.env'),
    'env_file_readable' => is_readable(__DIR__ . '/../.env'),
    'env_file_path' => __DIR__ . '/../.env',
    'brevo_api_key_defined' => defined('BREVO_API_KEY'),
    'brevo_api_key_length' => defined('BREVO_API_KEY') ? strlen(BREVO_API_KEY) : 0,
    'brevo_api_key_preview' => defined('BREVO_API_KEY') ? substr(BREVO_API_KEY, 0, 20) . '...' : 'NOT DEFINED',
    '_env_brevo_key' => isset($_ENV['BREVO_API_KEY']) ? 'SET' : 'NOT SET',
    'getenv_brevo_key' => getenv('BREVO_API_KEY') !== false ? 'SET' : 'NOT SET',
];

echo json_encode($result, JSON_PRETTY_PRINT);

