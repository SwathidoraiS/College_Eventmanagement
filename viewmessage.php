<?php
session_start();
include_once 'includes/db.php';

// Only allow admin
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
  $deleteId = intval($_GET['delete']);
  mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $deleteId");
  header("Location: viewmessage.php?deleted=1");
  exit();
}

// Fetch all messages
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Messages - Admin Panel</title>
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
      background-color: #ff4d4d;
      color: white;
      border: none;
    }

    .btn-delete:hover {
      background-color: #e60000;
    }

    .btn-back {
      border: 1px solid #00ff88;
      color: #00ff88;
      margin-top: 30px;
    }

    .btn-back:hover {
      background-color: #00ff88;
      color: black;
    }

    .alert-success {
      color: #0f0;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="text-center mb-4">📩 Contact Messages</h2>

  <?php if (isset($_GET['deleted'])): ?>
    <p class="text-center alert-success">✅ Message deleted successfully!</p>
  <?php endif; ?>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Sender</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a href="viewmessage.php?delete=<?= $row['id'] ?>"
                   onclick="return confirm('Are you sure you want to delete this message?');"
                   class="btn btn-sm btn-delete">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center">No messages found.</p>
  <?php endif; ?>

  <div class="text-center">
    <a href="adminhome.php" class="btn btn-back">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>
