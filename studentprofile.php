<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Student') {
    header("Location: login.php");
    exit();
}

include_once 'includes/db.php';
$userid = $_SESSION['userid'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE userid='$userid'");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #0a0f0d;
      background-image: url('assets/background-green.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    .profile-container {
      max-width: 500px;
      margin: 50px auto;
      background-color: rgba(20, 20, 20, 0.95);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,255,136,0.2);
    }

    .btn-custom {
      background-color: #00ff88;
      color: black;
      font-weight: bold;
    }

    .btn-custom:hover {
      background-color: #00cc66;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h3 class="text-center mb-4">Student Profile</h3>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>User ID:</strong> <?= htmlspecialchars($user['userid']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>

    <div class="text-center mt-4">
      <a href="changepassword.php" class="btn btn-custom w-100">Change Password</a>
    </div>
  </div>
</body>
</html>
