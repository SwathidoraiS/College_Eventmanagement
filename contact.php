<?php
include_once 'includes/db.php';

$success = "";

if (isset($_POST['send'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  $insert = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
  if (mysqli_query($conn, $insert)) {
    $success = "✅ Message sent successfully!";
  } else {
    $success = "❌ Failed to send message.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us - College Event Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #0a0f0d;
      color: white;
    }

    .contact-section {
      padding: 60px 20px;
    }

    .highlight {
      color: #00ff88;
      font-weight: bold;
    }

    .form-container {
      background-color: #1a1a1a;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #00ff88;
    }

    .btn-submit {
      background-color: #00ff88;
      color: black;
      border: none;
    }

    .btn-submit:hover {
      background-color: #00e676;
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

    .success-msg {
      color: #00ff88;
      font-weight: bold;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container contact-section text-center">
  <h1 class="mb-4 highlight">Contact Us</h1>

  <?php if ($success): ?>
    <p class="success-msg"><?= $success ?></p>
  <?php endif; ?>

  <p class="lead mb-5">Have questions or suggestions? Fill out the form below and we’ll get back to you!</p>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <form method="POST" action="">
        <div class="form-container">
          <div class="mb-3 text-start">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required />
          </div>

          <div class="mb-3 text-start">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required />
          </div>

          <div class="mb-3 text-start">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" required />
          </div>

          <div class="mb-3 text-start">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
          </div>

          <div class="text-center">
            <button type="submit" name="send" class="btn btn-submit px-4">Send Message</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <a href="index.php" class="btn btn-back">← Back to Home</a>
</div>

</body>
</html>
