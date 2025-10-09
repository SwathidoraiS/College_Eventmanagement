<?php
include_once 'includes/db.php';
session_start();

if (isset($_POST['login'])) {
    $role = $_POST['role'];
    $userid = trim($_POST['userid']);
    $password = $_POST['password'];

    // Use prepared statement
    $stmt = mysqli_prepare($conn, "SELECT userid, username, password, role FROM users WHERE userid = ? AND role = ?");
    mysqli_stmt_bind_param($stmt, "ss", $userid, $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($role === 'Admin') {
                header("Location: adminhome.php");
            } elseif ($role === 'Faculty') {
                header("Location: lecturerhome.php");
            } else {
                header("Location: studenthome.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Invalid User ID or Role');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { background: #111827; color: #f8f9fa; }
    .login-box { max-width: 400px; margin: 70px auto; background-color: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; box-shadow: 0 0 15px #00ff88; }
    .form-control { background-color: #1f2937; color: white; border: 1px solid #00ff88; }
    .form-control::placeholder { color: #ccc; }
    .btn-login { background-color: #00ff88; color: black; font-weight: bold; }
    .btn-login:hover { background-color: #00cc66; }
    .register-link { color: #00ff88; text-decoration: none; }
  </style>
</head>
<body>
<div class="container">
  <div class="login-box">
    <h3 class="text-center mb-4">Login</h3>
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
        <label>User ID</label>
        <input type="text" name="userid" class="form-control" placeholder="Enter your User ID" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>
      <div class="text-center mb-2">
        <button type="submit" name="login" class="btn btn-login">Login</button>
      </div>
      <p class="text-center">Don't have an account? <a href="register.php" class="register-link">Register here</a></p>
    </form>
  </div>
</div>
</body>
</html>
