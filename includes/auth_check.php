<?php
require_once __DIR__ . '/session.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function require_auth($roles = []) {
    if (!isLoggedIn()) {
        header('Location: /login');
        exit();
    }
    if (!empty($roles) && !in_array($_SESSION['role'], $roles) && $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        require __DIR__ . '/../views/403.phtml';
        exit();
    }
}

function require_sarkari_hr() {
    require_auth(['hr']);
    if (!$_SESSION['is_sarkari_hr'] && $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        require __DIR__ . '/../views/403.phtml';
        exit();
    }
}
