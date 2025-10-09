<?php
session_start();
include_once 'includes/db.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['id'])) {
  echo "Invalid event ID.";
  exit();
}

$event_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch event details
$result = mysqli_query($conn, "SELECT * FROM events WHERE id='$event_id'");
if (mysqli_num_rows($result) === 0) {
  echo "Event not found.";
  exit();
}

$event = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
  $department = mysqli_real_escape_string($conn, $_POST['department']);
  $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
$max_participants = $_POST['max_participants'];
  $update = "UPDATE events SET 
              event_name='$event_name', 
              department='$department', 
              event_date='$event_date', 
              max_participants = $max_participants,
              description='$description'
             WHERE id='$event_id'";

  if (mysqli_query($conn, $update)) {
    echo "<script>alert('✅ Event updated successfully'); window.location.href='allevents.php';</script>";
    exit();
  } else {
    $msg = "❌ Failed to update event: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Event</title>
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
  <h3 class="text-center mb-4">Edit Event</h3>

  <?php if (isset($msg)): ?>
    <div class="alert alert-danger text-center"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Event Name</label>
      <input type="text" name="event_name" class="form-control" value="<?= htmlspecialchars($event['event_name']) ?>" required>
    </div>

    <div class="mb-3">
      <label>Department</label>
      <select name="department" class="form-control" required>
        <option value="">Select Department</option>
        <?php
        $departments = ['Computer Science', 'Chemistry', 'Physics', 'Mathematics', 'Geology', 'Psychology'];
        foreach ($departments as $dept) {
          $selected = ($event['department'] === $dept) ? 'selected' : '';
          echo "<option value='$dept' $selected>$dept</option>";
        }
        ?>
      </select>
    </div>
<div class="mb-3">
  <label for="max_participants" class="form-label">Maximum Participants</label>
  <input type="number" class="form-control" id="max_participants" name="max_participants"
         value="<?= $row['max_participants'] ?>" min="1" required>
</div>

    <div class="mb-3">
      <label>Event Date</label>
      <input type="date" name="event_date" class="form-control" value="<?= $event['event_date'] ?>" required>
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-success px-4">Update Event</button>
    </div>
  </form>

  <div class="text-center mt-4">
    <a href="allevents.php" class="btn btn-outline-light">← Back to Event List</a>
  </div>
</div>

</body>
</html>
