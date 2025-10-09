<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Student') {
    header("Location: login.php");
    exit();
}

include_once 'includes/db.php'; // Ensure $conn is defined in db.php
$userid = $_SESSION['userid'];

// Handle registration after confirmation
if (isset($_POST['confirm_register'])) {
    $event_id = $_POST['event_id'];

    // Check if already registered
    $check = mysqli_query($conn, "SELECT * FROM registrations WHERE userid='$userid' AND event_id='$event_id'");
    if (mysqli_num_rows($check) == 0) {
        $event_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id='$event_id'"));
        $department = $event_data['department'];
        $max_participants = $event_data['max_participants'];

        // Check limit
        $check_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM registrations WHERE event_id='$event_id'");
        $registered_count = mysqli_fetch_assoc($check_total)['total'];

        if ($registered_count >= $max_participants) {
            echo "<script>alert('Registration Full for this event.');</script>";
        } else {
            mysqli_query($conn, "INSERT INTO registrations (name, email, department, event_id, userid) 
                VALUES ('Student', 'student@example.com', '$department', '$event_id', '$userid')");
            echo "<script>alert('Event registered successfully!');</script>";
        }
    } else {
        echo "<script>alert('You already registered for this event.');</script>";
    }
}

// Group events by department
$grouped_events = [];
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY department, event_date");
while ($row = mysqli_fetch_assoc($events)) {
    $dept = $row['department'];
    $grouped_events[$dept][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #380a78ff, #691cbaff, #2a0763ff);
      color: white;
    }
    #particles-js {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      background-color: #000;
    }
    .card {
      width: 210px;
      height: 270px;
      margin: 30px;
      border-radius: 20px;
      background: linear-gradient(135deg, rgba(30,30,30,0.9), rgba(50,50,50,0.8));
      box-shadow: 0 0 15px rgba(0, 255, 136, 0.15);
      transition: transform 0.2s ease;
    }
    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      height: 100%;
    }
    .card-body .mt-auto { margin-top: auto; }
    .card:hover { transform: scale(1.03); box-shadow: 0 0 25px #00ff88; }
    .card img { height: 100px; object-fit: contain; background-color: transparent; }
    .department-title {
      margin: 40px 0 20px;
      font-size: 1.8rem;
      font-weight: 600;
      color: #00ff88;
    }
    .event-type {
      font-size: 15px;
      text-align: center;
      text-transform: uppercase;
      color: white;
      font-weight: bold;
      text-shadow: 0 0 5px #00ff88;
      margin-bottom: 10px;
    }
    .btn-success {
      background-color: #00ff88;
      color: #000;
      font-weight: bold;
      border: none;
    }
    .btn-success:hover { background-color: #00cc66; }
    .modal-content {
      border-radius: 15px;
      border: 1px solid #00ff88;
      background-color: #1a1a1a;
      color: white;
    }
    .modal-header, .modal-footer { border: none; }
  </style>
</head>

<div id="particles-js"></div>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
particlesJS("particles-js", {
  "particles": {
    "number": { "value": 100, "density": { "enable": true, "value_area": 700 }},
    "color": { "value": "#00ff88" },
    "shape": { "type": "circle", "polygon": { "nb_sides": 5 }},
    "opacity": { "value": 0.6, "random": true },
    "size": { "value": 3, "random": true },
    "line_linked": { "enable": true, "distance": 120, "color": "#00ff88", "opacity": 0.4, "width": 1.2 },
    "move": { "enable": true, "speed": 2, "direction": "none", "out_mode": "out" }
  },
  "interactivity": {
    "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": true, "mode": "push" }, "resize": true },
    "modes": { "grab": { "distance": 140, "line_linked": { "opacity": 0.5 } }, "push": { "particles_nb": 4 } }
  },
  "retina_detect": true
});
</script>

<body>
<!-- Filter Dropdown -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div></div>
  <div>
    <label for="deptFilter" class="form-label me-2 text-end">Filter by</label>
    <select id="deptFilter" class="form-select d-inline-block w-auto">
      <option value="all">All Departments</option>
      <?php foreach ($grouped_events as $department => $evts): ?>
        <option value="<?= htmlspecialchars($department) ?>"><?= htmlspecialchars($department) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="container py-5">
  <h2 class="text-center mb-4">All Events</h2>

  <?php foreach ($grouped_events as $department => $events): ?>
    <div class="event-dept-section" data-dept="<?= htmlspecialchars($department) ?>">
      <div class="department-title"><?= htmlspecialchars($department) ?></div>
      <div class="d-flex flex-wrap gap-4">
        <?php foreach ($events as $event): ?>
          <?php
            $event_id = $event['id'];
            $event_name = mysqli_real_escape_string($conn, $event['event_name']);

            $check = mysqli_query($conn, "SELECT * FROM registrations WHERE userid='$userid' AND event_id='$event_id'");
            $is_registered = mysqli_num_rows($check) > 0;

            $count_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM registrations WHERE event_id='$event_id'");
            $current_count = mysqli_fetch_assoc($count_result)['total'];
            $max_participants = $event['max_participants'];
          ?>
          <div class="card">
            <div class="card-body text-center">
              <small class="text-muted d-block mb-2"><?= date("d M Y", strtotime($event['event_date'])) ?></small>
              <span class="position-absolute top-0 start-0 badge rounded-pill bg-success px-2 py-1 m-2">TECHNICAL</span>

              <h6><?= htmlspecialchars($event_name) ?></h6>
              <div class="bg-gradient text-white py-2 px-3 rounded mb-3" style="background:linear-gradient(45deg,#00ff88,#007f5f); margin-top: -30px;">
                <?= date("d M", strtotime($event['event_date'])) ?>
              </div>

              <div class="text-center mb-2">
                <span style="font-size: 22px;">🎯</span>
                <hr style="border: 1px solid #00ff88; width: 30px; margin: 5px auto;">
              </div>

              <div class="event-type"><?= strtoupper($event_name) ?></div>

              <div class="mt-auto">
                <?php if ($is_registered): ?>
                  <button class="btn btn-sm btn-secondary w-100" disabled>Registered</button>
                <?php elseif ($current_count >= $max_participants): ?>
                  <button class="btn btn-sm btn-danger w-100" disabled>Registration Full</button>
                <?php else: ?>
                  <button class="btn btn-sm btn-success w-100" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $event_id ?>">Register</button>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="confirmModal<?= $event_id ?>" tabindex="-1" aria-labelledby="confirmModalLabel<?= $event_id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmModalLabel<?= $event_id ?>">Confirm Registration</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><strong>Event Name:</strong> <?= htmlspecialchars($event_name) ?></p>
                  <p><strong>Department:</strong> <?= htmlspecialchars($event['department']) ?></p>
                  <p><strong>Date:</strong> <?= date("d M Y", strtotime($event['event_date'])) ?></p>
                  <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                  <p><strong>Capacity:</strong> <?= $current_count ?> / <?= $max_participants ?></p>
                </div>
                <div class="modal-footer">
                  <?php if ($is_registered || $current_count >= $max_participants): ?>
                    <button class="btn btn-secondary w-100" disabled>Cannot Register</button>
                  <?php else: ?>
                    <form method="POST" class="w-100">
                      <input type="hidden" name="event_id" value="<?= $event_id ?>">
                      <button type="submit" name="confirm_register" class="btn btn-success w-100">Confirm Registration</button>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="text-center mt-5">
    <a href="studenthome.php" class="btn btn-outline-light">← Back to Dashboard</a>
  </div>
</div>

<script>
document.getElementById('deptFilter').addEventListener('change', function () {
    const selectedDept = this.value.toLowerCase();
    const sections = document.querySelectorAll('.event-dept-section');

    sections.forEach(section => {
        const dept = section.getAttribute('data-dept').toLowerCase();
        section.style.display = (selectedDept === 'all' || dept === selectedDept) ? 'block' : 'none';
    });
});
</script>

</body>
</html>
