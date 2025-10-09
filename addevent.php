<?php
session_start();
include_once 'includes/db.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
  $department = mysqli_real_escape_string($conn, $_POST['department']);
  $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $max_participants = mysqli_real_escape_string($conn, $_POST['max_participants']);


  $sql = "INSERT INTO events (event_name, department, event_date, description,max_participants) 
          VALUES ('$event_name', '$department', '$event_date', '$description','$max_participants')";
  if (mysqli_query($conn, $sql)) {
    $msg = "✅ Event added successfully!";
  } else {
    $msg = "❌ Failed to add event: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Event</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #0a0f0d;
      color: white;
    }
    .form-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      background-color: #1a1a1a;
      border-radius: 10px;
      box-shadow: 0 0 10px #00ff88;
    }
    label {
      font-weight: bold;
    }
    .btn-success {
      background-color: #00ff88;
      color: black;
      border: none;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h3 class="text-center mb-4">Add New Event</h3>

  <?php if (isset($msg)): ?>
    <div class="alert alert-info text-center"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Event Name</label>
      <input type="text" name="event_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Department</label>
      <select name="department" class="form-control" required>
        <option value="">Select Department</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Chemistry">Chemistry</option>
        <option value="Physics">Physics</option>
        <option value="Mathematics">Mathematics</option>
        <option value="Geology">Geology</option>
        <option value="Psychology">Psychology</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Event Date</label>
      <input type="date" name="event_date" class="form-control" required>
    </div>

    <div class="mb-3">
    <label for="max_participants" class="form-label">Maximum Participants</label>
    <input type="number" class="form-control" id="max_participants" name="max_participants" min="1" required>
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-success px-4">Add Event</button>
    </div>
  </form>

  <div class="text-center mt-4">
    <a href="adminhome.php" class="btn btn-outline-light">← Back to Admin Dashboard</a>
  </div>
</div>

</body>
</html>
