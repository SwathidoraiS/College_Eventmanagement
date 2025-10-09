<?php
session_start();
include_once 'includes/db.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

// Delete user if requested
if (isset($_GET['delete_user'])) {
  $delete_id = $_GET['delete_user'];

  // Prevent admin from deleting their own account
  if ($delete_id != $_SESSION['userid']) {
    mysqli_query($conn, "DELETE FROM users WHERE userid = '$delete_id'");
    header("Location: users.php"); // Refresh to update list
    exit();
  }
}

// Fetch all users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY role, username ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Users - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #0a0f0d;
      color: white;
    }

    .container {
      margin-top: 50px;
    }

    .table {
      background-color: #1a1a1a;
      color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px #00ff88;
    }

    .table th {
      background-color: #00ff88;
      color: black;
    }

    .btn-delete {
      background-color: transparent;
      border: 1px solid #ff4d4d;
      color: #ff4d4d;
    }

    .btn-delete:hover {
      background-color: #ff4d4d;
      color: white;
    }

    .btn-back {
      background-color: transparent;
      border: 1px solid #00ff88;
      color: #00ff88;
      margin-top: 20px;
    }

    .btn-back:hover {
      background-color: #00ff88;
      color: black;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="text-center mb-4">All Registered Users</h2>

  <?php if (mysqli_num_rows($users) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Username</th>
            <th>User ID</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($user = mysqli_fetch_assoc($users)): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= htmlspecialchars($user['userid']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
              <td>
                <?php if ($user['userid'] != $_SESSION['userid']): ?>
                  <a href="users.php?delete_user=<?= $user['userid'] ?>" 
                     class="btn btn-sm btn-delete"
                     onclick="return confirm('Are you sure you want to delete this user?');">
                    Delete
                  </a>
                <?php else: ?>
                  <span class="text-muted">Your Account</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center">No users found.</p>
  <?php endif; ?>

  <div class="text-center">
    <a href="adminhome.php" class="btn btn-back">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>
