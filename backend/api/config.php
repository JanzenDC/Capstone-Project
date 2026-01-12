<?php
/**
 * Configuration file for API keys
 * For production, use environment variables or a .env file
 */

// Load environment variables from .env file if it exists
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile) && is_readable($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip empty lines and comments
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        // Check if line contains '='
        if (strpos($line, '=') === false) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        // Remove quotes if present
        $value = trim($value, '"\'');
        if (!empty($name) && !empty($value)) {
            $_ENV[$name] = $value;
            putenv($name . '=' . $value);
        }
    }
}

// Brevo API Key - can be overridden by environment variable
// First check $_ENV, then getenv(), then fallback to default
$brevoApiKey = null;
if (isset($_ENV['BREVO_API_KEY']) && !empty($_ENV['BREVO_API_KEY'])) {
    $brevoApiKey = $_ENV['BREVO_API_KEY'];
} elseif (getenv('BREVO_API_KEY') !== false && !empty(getenv('BREVO_API_KEY'))) {
    $brevoApiKey = getenv('BREVO_API_KEY');
} else {
    // Fallback to default (you should replace this with your actual API key or use .env file)
    $brevoApiKey = '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';
}

define('BREVO_API_KEY', $brevoApiKey);


