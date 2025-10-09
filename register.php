<?php
include_once 'includes/db.php'; // this must define $conn

if (isset($_POST['register'])) {
    $role = $_POST['role'];
    $username = trim($_POST['username']);
    $userid = trim($_POST['userid']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match');</script>";
        exit();
    }

    // Check if userid already exists
    $stmt_check = mysqli_prepare($conn, "SELECT userid FROM users WHERE userid = ?");
    mysqli_stmt_bind_param($stmt_check, "s", $userid);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        echo "<script>alert('User ID already exists. Choose a different one.');</script>";
        exit();
    }

    mysqli_stmt_close($stmt_check);

    // Hash password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = mysqli_prepare($conn, "INSERT INTO users (role, username, userid, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $role, $username, $userid, $password_hashed);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Registration Successful'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error while registering: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { background: #111827; color: #f8f9fa; }
    .register-box { max-width: 500px; margin: 60px auto; background-color: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; box-shadow: 0 0 15px #00ff88; }
    .form-control, .form-select { background-color: #1f2937; color: white; border: 1px solid #00ff88; }
    .form-control::placeholder { color: #ccc; }
    .btn-register { background-color: #00ff88; color: black; font-weight: bold; }
    .btn-register:hover { background-color: #00cc66; }
    .login-link { color: #00ff88; text-decoration: none; }
    .login-link:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="container">
  <div class="register-box">
    <h3 class="text-center mb-4">User Registration</h3>
    <form method="POST" action="">
      <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-select" required>
          <option value="">Select Role</option>
          <option value="Student">Student</option>
          <option value="Admin">Admin</option>
          <option value="Faculty">Faculty</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required placeholder="Enter username">
      </div>
      <div class="mb-3">
        <label>User ID</label>
        <input type="text" name="userid" class="form-control" required placeholder="Enter user ID">
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required placeholder="Enter password">
      </div>
      <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="cpassword" class="form-control" required placeholder="Re-enter password">
      </div>
      <div class="text-center mb-2">
        <button type="submit" name="register" class="btn btn-register">Register</button>
      </div>
      <p class="text-center">Already registered? <a href="login.php" class="login-link">Click here to login</a></p>
    </form>
  </div>
</div>
</body>
</html>
