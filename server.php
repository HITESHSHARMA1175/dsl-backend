<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$publicPath = __DIR__.'/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

$filePath = $publicPath . $uri;

if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    $mime = mime_content_type($filePath);
    if (str_ends_with($filePath, '.css')) {
        $mime = 'text/css';
    } elseif (str_ends_with($filePath, '.js')) {
        $mime = 'application/javascript';
    }
    header("Content-Type: " . $mime);
    readfile($filePath);
    exit;
}

require_once $publicPath . '/index.php';
