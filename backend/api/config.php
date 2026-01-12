<?php
/**
 * Configuration file for API keys
 * For production, use environment variables or a .env file
 */

// Load environment variables from .env file if it exists
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
        putenv(trim($name) . '=' . trim($value));
    }
}

// Brevo API Key - can be overridden by environment variable
define('BREVO_API_KEY', getenv('BREVO_API_KEY') ?: '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');


