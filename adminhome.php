<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0a0f0d;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,255,136,0.15);
      background-color: #1a1a1a;
      color: white;
      transition: 0.2s ease;
    }
    .card:hover {
      box-shadow: 0 0 20px #00ff88;
      transform: scale(1.02);
    }
    .btn {
      border-radius: 8px;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-5">Welcome, Admin</h2>

  <div class="row g-4 justify-content-center">
    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>Add New Event</h5>
        <a href="addevent.php" class="btn btn-success mt-3">Add Event</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>View All Events</h5>
        <a href="allevents.php" class="btn btn-info mt-3">Show Events</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>View Registrations</h5>
        <a href="registrations.php" class="btn btn-warning mt-3">View</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>All Users</h5>
        <a href="users.php" class="btn btn-primary mt-3">View Users</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>View Contact message</h5>
        <a href="viewmessage.php" class="btn btn-info mt-3">View Contact message</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>Profile</h5>
        <a href="adminprofile.php" class="btn btn-warning mt-3">View Profile</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4">
        <h5>Logout</h5>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
