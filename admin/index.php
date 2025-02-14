<?php
session_start();
// If admin is already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    /* Basic styling */
    body { font-family: Arial, sans-serif; background: #f2f2f2; }
    .login-container {
      width: 300px;
      margin: 100px auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; }
    .form-group input { width: 100%; padding: 8px; }
    .btn {
      width: 100%;
      padding: 10px;
      background: #007BFF;
      border: none;
      color: #fff;
      cursor: pointer;
      border-radius: 5px;
    }
    .btn:hover { background: #0056b3; }
    .error { color: red; text-align: center; }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <?php
      if (isset($_SESSION['error'])) {
          echo '<p class="error">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);
      }
    ?>
    <form action="admin_login.php" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
  </div>
</body>
</html>
