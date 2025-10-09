<?php include_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>College Event Management</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Particles.js Library -->
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

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
  z-index: -1; /* behind everything */
  background-color: #000;
}



    /* Navbar */
    .navbar {
      background: linear-gradient(45deg, #6a11cb, #2575fc);
    }
    .nav-link:hover {
      color: #ffd700 !important;
    }

    /* Hero section */
    .hero {
        background: url('assets/images/banner.jpg') no-repeat center center/cover;
        height: 26vh;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
    }

    

        .time-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #002b0f;
    border-radius: 12px;
    padding: 20px 25px;
    box-shadow: 0 0 20px #00ff6a;
    }

    .time-value {
    font-size: 3rem;
    font-weight: bold;
    color: white;
    }

    .time-label {
    font-size: 1rem;
    color: #a8f5c6;
    margin-top: 5px;
    }

    /* Countdown */
    #countdown {
      font-size: 2rem;
      font-weight: bold;
      color: #17a2b8;
    }
    .countdown-section {
      background: linear-gradient(135deg, #c33764, #1d2671);
      color: #fff;
      padding: 50px 20px;
    }

    /* Footer */
    footer {
      background: linear-gradient(45deg, #343a40, #212529);
      color: #ccc;
    }

    .main-buttons {
      margin-top: 2rem;
    }
  </style>
</head>
<!-- Particle Background -->
<div id="particles-js"></div>

<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">MCC</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
      </ul>
      <a href="login.php" class="btn btn-warning">Login</a>
    </div>
  </div>
</nav>

<!-- ✅ Stylish Hero Section (Colorful Text + No Box) -->
<section class="hero text-center d-flex align-items-center justify-content-center">
  <div>
    <h1 class="fw-bold display-4">
      <span style="color: #00bfff;">Malankara Catholic College</span> 
    </h1>
    <p class="fs-5 mt-3 text-white">Register, Participate, and Celebrate the Spirit of College Life</p>
  </div>
</section>

<script>
particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 150,  // 🔼 more particles
      "density": {
        "enable": true,
        "value_area": 750
      }
    },
    "color": { "value": "#00ff88" }, // neon green
    "shape": {
      "type": "circle",
      "stroke": { "width": 0, "color": "#000" },
      "polygon": { "nb_sides": 5 }
    },
    "opacity": {
      "value": 0.6,  // 🔼 brighter dots
      "random": true,
      "anim": { "enable": false }
    },
    "size": {
      "value": 3,
      "random": true
    },
    "line_linked": {
      "enable": true,
      "distance": 120,
      "color": "#00ff88",
      "opacity": 0.5, // 🔼 brighter lines
      "width": 1.2
    },
    "move": {
      "enable": true,
      "speed": 2,
      "direction": "none",
      "out_mode": "out"
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": { "enable": true, "mode": "grab" },
      "onclick": { "enable": true, "mode": "push" },
      "resize": true
    },
    "modes": {
      "grab": { "distance": 120, "line_linked": { "opacity": 0.5 } },
      "push": { "particles_nb": 4 }
    }
  },
  "retina_detect": true
});
</script>




<!-- ✅ Countdown Section Styled Like the Image -->
<section class="text-center py-5">
  <h2 class="text-success mb-4">Next Big Event Starts In:</h2>
  <div id="timer" class="d-flex justify-content-center gap-4 flex-wrap">
    <div class="time-box">
      <div class="time-value" id="days">0</div>
      <div class="time-label">Days</div>
    </div>
    <div class="time-box">
      <div class="time-value" id="hours">0</div>
      <div class="time-label">Hours</div>
    </div>
    <div class="time-box">
      <div class="time-value" id="minutes">0</div>
      <div class="time-label">Minutes</div>
    </div>
    <div class="time-box">
      <div class="time-value" id="seconds">0</div>
      <div class="time-label">Seconds</div>
    </div>
  </div>
</section>


<!-- ✅ Action Buttons Section -->
<section class="text-center main-buttons mb-5">
  <a href="register.php" class="btn btn-success btn-lg me-3">Register</a>
  <a href="events.php" class="btn btn-primary btn-lg">View Events</a>
</section>

<!-- ✅ Footer -->
<footer class="text-center p-3 mt-5">
  © 2025 MCC | Designed by CS Students 💻🎓
</footer>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const eventDate = new Date("October 25, 2025 09:00:00").getTime();

  function updateCountdown() {
    const now = new Date().getTime();
    const distance = eventDate - now;

    if (distance < 0) {
      document.getElementById("timer").innerHTML = "The event has started!";
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("days").innerText = days;
    document.getElementById("hours").innerText = hours;
    document.getElementById("minutes").innerText = minutes;
    document.getElementById("seconds").innerText = seconds;
  }

  setInterval(updateCountdown, 1000);
  updateCountdown();
</script>


</body>
</html>
