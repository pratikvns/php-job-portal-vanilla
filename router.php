<?php
// A simple, secure router for handling clean URLs.
require_once __DIR__ . '/includes/session.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url_parts = explode('/', $url);

$controller = $url_parts[0] ?: 'home';
$method = $url_parts[1] ?? null;

// Whitelist of allowed pages to prevent file inclusion vulnerabilities
$pages_whitelist = [
    'home', 'login', 'register', 'logout', 'verify_email', 'sarkari_detail', 'job_detail',
    'admin/dashboard', 'admin/manage_users',
    'hr/dashboard', 'hr/post_private_job', 'hr/post_sarkari_job',
    'user/dashboard'
];

// Construct the file path
$file_path = $controller . ($method ? '/' . $method : '');
$full_file_path = __DIR__ . '/' . str_replace('/', DIRECTORY_SEPARATOR, $file_path) . '.php';

if (in_array($file_path, $pages_whitelist) && file_exists($full_file_path)) {
    require_once $full_file_path;
} elseif ($controller === 'sarkari' && is_numeric($method)) {
    $_GET['id'] = (int)$method;
    require_once __DIR__ . '/sarkari_detail.php';
} elseif ($controller === 'job' && is_numeric($method)) {
    $_GET['id'] = (int)$method;
    require_once __DIR__ . '/job_detail.php';
} else {
    // Default to home page
    require_once __DIR__ . '/home.php';
}
