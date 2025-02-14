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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $fullName   = trim($_POST['fullName']);
    $school     = trim($_POST['school']);
    $department = trim($_POST['department']);
    $cgpa       = floatval($_POST['cgpa']);
    $age        = intval($_POST['age']);
    $siwesType  = trim($_POST['siwesType']);
    $email      = trim($_POST['email']);

    // Update record
    $sql = "UPDATE applications 
            SET full_name = :fullName, school = :school, department = :department, cgpa = :cgpa, age = :age, siwes_type = :siwesType, email = :email 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        ':fullName'   => $fullName,
        ':school'     => $school,
        ':department' => $department,
        ':cgpa'       => $cgpa,
        ':age'        => $age,
        ':siwesType'  => $siwesType,
        ':email'      => $email,
        ':id'         => $id
    ])) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating applicant.";
    }
} else {
    // Fetch current applicant details
    $stmt = $pdo->prepare("SELECT * FROM applications WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $applicant = $stmt->fetch();
    if (!$applicant) {
        die("Applicant not found.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Applicant</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f2f2f2; margin: 0; padding: 20px; }
    .container {
      max-width: 500px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
    }
    h1 { text-align: center; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; }
    .form-group input, .form-group select { width: 100%; padding: 8px; }
    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background: #007BFF;
      color: #fff;
      border: none;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
    }
    .btn:hover { background: #0056b3; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Applicant</h1>
    <form method="POST" action="">
      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" name="fullName" id="fullName" value="<?php echo htmlspecialchars($applicant['full_name']); ?>" required>
      </div>
      <div class="form-group">
        <label for="school">School</label>
        <input type="text" name="school" id="school" value="<?php echo htmlspecialchars($applicant['school']); ?>" required>
      </div>
      <div class="form-group">
        <label for="department">Department</label>
        <input type="text" name="department" id="department" value="<?php echo htmlspecialchars($applicant['department']); ?>" required>
      </div>
      <div class="form-group">
        <label for="cgpa">CGPA</label>
        <input type="number" step="0.01" name="cgpa" id="cgpa" value="<?php echo htmlspecialchars($applicant['cgpa']); ?>" required>
      </div>
      <div class="form-group">
        <label for="age">Age</label>
        <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($applicant['age']); ?>" required>
      </div>
      <div class="form-group">
        <label for="siwesType">SIWES Type</label>
        <select name="siwesType" id="siwesType" required>
          <option value="AI" <?php if($applicant['siwes_type'] == 'AI') echo 'selected'; ?>>AI</option>
          <option value="Network" <?php if($applicant['siwes_type'] == 'Network') echo 'selected'; ?>>Network and Security</option>
          <option value="System" <?php if($applicant['siwes_type'] == 'System') echo 'selected'; ?>>System Control</option>
        </select>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo isset($applicant['email']) ? htmlspecialchars($applicant['email']) : ''; ?>" required>
      </div>
      <button type="submit" class="btn">Update Applicant</button>
    </form>
  </div>
</body>
</html>
