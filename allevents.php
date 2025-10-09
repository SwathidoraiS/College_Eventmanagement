<?php
session_start();
include_once 'includes/db.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

// Handle delete event
if (isset($_POST['delete_event'])) {
  $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
  mysqli_query($conn, "DELETE FROM events WHERE id='$event_id'");
  echo "<script>alert('Event deleted successfully'); window.location.href='allevents.php';</script>";
  exit();
}

// Fetch and group events by department
$grouped_events = [];
$result = mysqli_query($conn, "SELECT * FROM events ORDER BY department, event_date ASC");
while ($row = mysqli_fetch_assoc($result)) {
  $dept = $row['department'];
  $grouped_events[$dept][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Events - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #0a0f0d;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    .department-heading {
      margin-top: 40px;
      margin-bottom: 20px;
      font-size: 1.8rem;
      font-weight: bold;
      color: #00ff88;
      border-bottom: 1px solid #00ff88;
      padding-bottom: 5px;
    }

    .event-card {
      background-color: #1a1a1a;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 0 10px rgba(0,255,136,0.15);
    }

    .event-card h5 {
      color: #00ff88;
    }

    .btn-back {
      background-color: transparent;
      border: 1px solid #00ff88;
      color: #00ff88;
    }

    .btn-back:hover {
      background-color: #00ff88;
      color: black;
    }

    .action-buttons {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-4">All Events</h2>

  <?php if (!empty($grouped_events)): ?>
    <?php foreach ($grouped_events as $department => $events): ?>
      <div class="department-heading"><?= htmlspecialchars($department) ?> </div>
      <div class="row">
        <?php foreach ($events as $event): ?>
          <div class="col-md-6">
            <div class="event-card">
              <h5><?= htmlspecialchars($event['event_name']) ?></h5>
              <p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
              <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($event['description'])) ?></p>

              <div class="action-buttons">
                <a href="editevent.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                  <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                  <button type="submit" name="delete_event" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center">No events found.</p>
  <?php endif; ?>

  <div class="text-center mt-5">
    <a href="adminhome.php" class="btn btn-back">← Back to Admin Dashboard</a>
  </div>
</div>

</body>
</html>
