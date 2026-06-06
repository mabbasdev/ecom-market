<?php
$productFolder = 'ecom-market';
$commonFuntionsPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $productFolder . 'includes/common_functions.php';

if (file_exists($commonFuntionsPath)) {
    include_once($commonFuntionsPath);
} else {
    error_log("CRITICAL ERROR: Common Functions was not found at" . $commonFuntionsPath);
}
if (!isset($baseURL)) {
    $baseURL = '/ecom-market/';
}

function getAbsoluteLink($path, $baseURL) {
    $cleanPath = ltrim($path, './');
    return rtrim($baseURL, '/') . '/' . $cleanPath;
}
