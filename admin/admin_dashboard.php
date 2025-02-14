<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Database configuration
$host    = 'localhost:3307';
$db      = 'siwes_db'; // Replace with your database name
$user    = 'root';     // Replace with your database username
$pass    = '';         // Replace with your database password
$charset = 'utf8mb4';

// Set up DSN and options using PDO
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

// Retrieve all applications
$stmt = $pdo->query("SELECT * FROM applications");
$applicants = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - SIWES Applications</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f2f2f2; margin: 0; padding: 20px; }
    h1 { text-align: center; }
    .logout { float: right; margin: 10px; }
    table { width: 100%; border-collapse: collapse; background: #fff; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    th { background: #007BFF; color: #fff; }
    .action-links a { margin-right: 5px; text-decoration: none; color: #007BFF; }
    .action-links a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <a href="logout.php" class="logout">Logout</a>
  <h1>SIWES Applications Dashboard</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>School</th>
        <th>Department</th>
        <th>CGPA</th>
        <th>Age</th>
        <th>SIWES Type</th>
        <th>Email</th>
        <th>Submission Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($applicants): ?>
        <?php foreach ($applicants as $applicant): ?>
          <tr>
            <td><?php echo htmlspecialchars($applicant['id']); ?></td>
            <td><?php echo htmlspecialchars($applicant['full_name']); ?></td>
            <td><?php echo htmlspecialchars($applicant['school']); ?></td>
            <td><?php echo htmlspecialchars($applicant['department']); ?></td>
            <td><?php echo htmlspecialchars($applicant['cgpa']); ?></td>
            <td><?php echo htmlspecialchars($applicant['age']); ?></td>
            <td><?php echo htmlspecialchars($applicant['siwes_type']); ?></td>
            <td>
              <?php 
                // Display email if available
                $email = isset($applicant['email']) ? $applicant['email'] : 'N/A';
                echo htmlspecialchars($email);
              ?>
            </td>
            <td><?php echo htmlspecialchars($applicant['submission_date']); ?></td>
            <td class="action-links">
              <a href="edit_applicant.php?id=<?php echo $applicant['id']; ?>">Edit</a>
              <a href="delete_applicant.php?id=<?php echo $applicant['id']; ?>" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
              <?php if($email !== 'N/A'): ?>
                <a href="mailto:<?php echo htmlspecialchars($email); ?>">Contact</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="10">No applications found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
