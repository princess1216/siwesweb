<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Database configuration
$host    = 'localhost:3307';
$db      = 'siwes_db';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid applicant ID.");
}

$stmt = $pdo->prepare("DELETE FROM applications WHERE id = :id");
if ($stmt->execute([':id' => $id])) {
    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "Error deleting applicant.";
}
?>
