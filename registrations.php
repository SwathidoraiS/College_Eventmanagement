<?php
session_start();
include_once 'includes/db.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

// Fetch event & department options
$event_options = mysqli_query($conn, "SELECT DISTINCT event_name FROM events ORDER BY event_name ASC");
$dept_options = mysqli_query($conn, "SELECT DISTINCT department FROM events ORDER BY department ASC");

// Handle filters
$event_filter = isset($_GET['event']) ? mysqli_real_escape_string($conn, $_GET['event']) : '';
$dept_filter = isset($_GET['department']) ? mysqli_real_escape_string($conn, $_GET['department']) : '';

// Build query with filters
$query = "SELECT r.*, u.username, u.userid, e.event_name, e.department, e.event_date
          FROM registrations r
          JOIN users u ON r.userid = u.userid
          JOIN events e ON r.event_id = e.id";

$conditions = [];
if (!empty($event_filter)) $conditions[] = "e.event_name = '$event_filter'";
if (!empty($dept_filter)) $conditions[] = "e.department = '$dept_filter'";

if (!empty($conditions)) {
  $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY e.event_date ASC, e.department, u.username";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Registrations</title>
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
    .filter-form select {
      margin-right: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="text-center mb-4">Event Registrations</h2>

  <!-- Filter form -->
  <form method="GET" class="d-flex justify-content-center mb-4 filter-form">
    <select name="event" class="form-select w-auto">
      <option value="">All Events</option>
      <?php while ($e = mysqli_fetch_assoc($event_options)): ?>
        <option value="<?= $e['event_name'] ?>" <?= $event_filter == $e['event_name'] ? 'selected' : '' ?>>
          <?= $e['event_name'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <select name="department" class="form-select w-auto">
      <option value="">All Departments</option>
      <?php while ($d = mysqli_fetch_assoc($dept_options)): ?>
        <option value="<?= $d['department'] ?>" <?= $dept_filter == $d['department'] ? 'selected' : '' ?>>
          <?= $d['department'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <button type="submit" class="btn btn-success">Filter</button>
    <a href="registrations.php" class="btn btn-outline-light ms-2">Clear</a>
  </form>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>User Name</th>
            <th>User ID</th>
            <th>Event Name</th>
            <th>Department</th>
            <th>Event Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['userid']) ?></td>
              <td><?= htmlspecialchars($row['event_name']) ?></td>
              <td><?= htmlspecialchars($row['department']) ?></td>
              <td><?= htmlspecialchars($row['event_date']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center">No registrations found for selected filter.</p>
  <?php endif; ?>

  <div class="text-center">
    <a href="adminhome.php" class="btn btn-back">← Back to Dashboard</a>
  </div>
</div>

</body>
</html>
