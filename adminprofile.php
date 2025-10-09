<?php
session_start();
include_once 'includes/db.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Fetch current admin info
$currentAdminId = $_SESSION['userid'];
$query = "SELECT * FROM users WHERE userid = '$currentAdminId'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_userid = mysqli_real_escape_string($conn, $_POST['new_userid']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

    // Hash password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update = "UPDATE users SET userid = '$new_userid', password = '$hashed_password' WHERE userid = '$currentAdminId'";
    if (mysqli_query($conn, $update)) {
        $_SESSION['userid'] = $new_userid; // update session
        $success = "✅ Profile updated successfully!";
    } else {
        $error = "❌ Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #0a0f0d;
      color: white;
    }
    .form-container {
      max-width: 500px;
      margin: 60px auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #00ff88;
    }
    .btn-save {
      background-color: #00ff88;
      color: black;
      border: none;
    }
    .btn-save:hover {
      background-color: #00cc66;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h3 class="text-center mb-4">🔐 Admin Profile</h3>

  <?php if (isset($success)): ?>
    <div class="alert alert-success text-center"><?= $success ?></div>
  <?php elseif (isset($error)): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="new_userid" class="form-label">New Admin ID</label>
      <input type="text" class="form-control" id="new_userid" name="new_userid" value="<?= htmlspecialchars($admin['userid']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="new_password" class="form-label">New Password</label>
      <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <button type="submit" class="btn btn-save w-100">💾 Update</button>
    <a href="adminhome.php" class="btn btn-secondary w-100 mt-3">← Back to Dashboard</a>
  </form>
</div>

</body>
</html>
