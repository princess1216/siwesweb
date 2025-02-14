<?php
// Database configuration
$host     = 'localhost:3307';
$db       = 'siwes_db'; // Replace with your database name
$user     = 'root';     // Replace with your database username
$pass     = '';         // Replace with your database password
$charset  = 'utf8mb4';

// Set up DSN and options
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a PDO instance (database connection)
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If connection fails, display error (in production, log this error instead)
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $fullName    = trim($_POST['fullName']);
    $school      = trim($_POST['school']);
    $department  = trim($_POST['department']);
    $cgpa        = floatval($_POST['cgpa']);
    $age         = intval($_POST['age']);
    $email      = trim($_POST['email']);
    $siwesType   = trim($_POST['siwesType']);
    $reason      = trim($_POST['reason']);

    // You can add further validation here if needed

    // Prepare an INSERT statement using placeholders for security
    $sql = "INSERT INTO applications (full_name, school, department, cgpa, age, email, siwes_type, reason)
            VALUES (:fullName, :school, :department, :cgpa, :age, :email, :siwesType, :reason)";
    
    $stmt = $pdo->prepare($sql);

    // Bind the parameters to the statement
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':school', $school);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':cgpa', $cgpa);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':siwesType', $siwesType);
    $stmt->bindParam(':reason', $reason);

    // Execute the statement and check if the insertion was successful
    if ($stmt->execute()) {
        // Redirect or display a success message
        echo "Application submitted successfully <a href='/siwes'>Go Back Home</a>.";
    } else {
        echo "There was an error submitting your application.";
    }
}
?>
