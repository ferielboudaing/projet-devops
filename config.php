<?php
// Configuration de NOVA - compatible PHP 5.5
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'nova_db');
define('DB_USER', 'root');
define('DB_PASS', '');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Erreur de connexion MySQL : ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
function require_role($roles) {
    require_login();
    if (!in_array($_SESSION['role'], $roles)) {
        header('Location: dashboard.php');
        exit;
    }
}
?>