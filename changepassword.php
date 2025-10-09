<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Student') {
    header("Location: login.php");
    exit();
}

include_once 'includes/db.php';

$userid = $_SESSION['userid'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current = trim($_POST['current']);
    $new = trim($_POST['new']);
    $confirm = trim($_POST['confirm']);

    $result = mysqli_query($conn, "SELECT password FROM users WHERE userid = '$userid'");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $storedPassword = $user['password'];

        if (password_verify($current, $storedPassword)) {
            if ($new === $confirm) {
                $hashed = password_hash($new, PASSWORD_DEFAULT);
                $update = mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE userid = '$userid'");
                
                if ($update) {
                    $message = "<div class='alert alert-success'>Password updated successfully!</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Failed to update password.</div>";
                }
            } else {
                $message = "<div class='alert alert-warning'>New passwords do not match.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Current password is incorrect.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>User not found.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #0a0f0d;
            background-image: url('assets/background-green.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 80px;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
        }
        .btn-primary {
            background-color: #00ff88;
            color: #000;
            font-weight: bold;
            border: none;
        }
        .btn-primary:hover {
            background-color: #00cc66;
        }
    </style>
</head>
<body>

<div class="container">
    <h4 class="text-center mb-4">Change Password</h4>
    <?= $message ?>
    <form method="POST">
        <div class="mb-3">
            <label for="current" class="form-label">Current Password</label>
            <input type="password" name="current" id="current" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="new" class="form-label">New Password</label>
            <input type="password" name="new" id="new" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="confirm" class="form-label">Confirm New Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Change Password</button>
    </form>
</div>

</body>
</html>
