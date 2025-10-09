<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Student') {
    header("Location: login.php");
    exit();
}

include_once 'includes/db.php';
$userid = $_SESSION['userid'];

// Fetch this student's registered events along with event details
$sql = "SELECT r.*, e.event_name, e.event_date 
        FROM registrations r
        JOIN events e ON r.event_id = e.id
        WHERE r.userid = '$userid'
        ORDER BY e.event_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Registered Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #111827;
      color: #f8f9fa;
    }

    .event-box {
      max-width: 1000px;
      margin: 50px auto;
      background-color: rgba(255,255,255,0.05);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px #00ff88;
    }

    table {
      color: white;
    }

    th, td {
      text-align: center;
      vertical-align: middle;
    }

    .table thead {
      background-color: #00ff88;
      color: black;
    }

    .btn-back {
      background-color: #00ff88;
      font-weight: bold;
      color: black;
    }

    .btn-back:hover {
      background-color: #00cc66;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="event-box">
    <h3 class="text-center mb-4">My Registered Events</h3>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>User ID</th>
            <th>Date Registered</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['event_name']) ?></td>
              <td><?= date("d M Y", strtotime($row['event_date'])) ?></td>
              <td><?= htmlspecialchars($row['userid']) ?></td>
              <td><?= date("d M Y", strtotime($row['registered_at'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-center text-warning">You haven't registered for any events yet.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
      <a href="studenthome.php" class="btn btn-back">← Back to Dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
