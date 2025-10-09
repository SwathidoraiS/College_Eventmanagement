<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Student') {
  header("Location: login.php");
  exit();
}
$userid = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body {
      background: #111827;
      color: #f8f9fa;
    }

    .dashboard-box {
      max-width: 700px;
      margin: 60px auto;
      background-color: rgba(255, 255, 255, 0.05);
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px #00ff88;
    }

    .btn-dashboard {
      background-color: #00ff88;
      color: black;
      font-weight: bold;
      margin: 10px 0;
    }

    .btn-dashboard:hover {
      background-color: #00cc66;
    }

    .navbar-custom {
      background-color: #0f172a;
      box-shadow: 0 0 10px #00ff88;
    }

    .navbar-brand, .nav-link {
      color: #00ff88 !important;
      font-weight: bold;
    }

    .nav-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Student Dashboard</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        
        
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ✅ Dashboard Welcome -->
<div class="container">
  <div class="dashboard-box text-center">
    <h2>Welcome<span class="text-success"></span> 👋</h2>
    <p>You're logged in as a <strong>Student</strong></p>

    <a href="events.php" class="btn btn-dashboard w-100">Register for an Event</a>
    <a href="myevents.php" class="btn btn-dashboard w-100">View My Registered Events</a>
<a href="studentprofile.php" class="btn btn-dashboard w-100">My Profile</a>
    

  </div>
</div>

</body>
</html>
