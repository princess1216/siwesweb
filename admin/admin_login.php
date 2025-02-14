<?php
session_start();

// Hardcoded admin credentials (in production, use a database and hash passwords)
$admin_username = 'admin';
$admin_password = 'admin123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: login.php");
        exit;
    }
}
?>
