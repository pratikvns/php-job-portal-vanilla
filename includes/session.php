<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // Set to true in production
    ini_set('session.use_strict_mode', 1);
    session_start();
}

if (!isset($_SESSION['last_regen']) || time() - $_SESSION['last_regen'] > (30 * 60)) {
    session_regenerate_id(true);
    $_SESSION['last_regen'] = time();
}
