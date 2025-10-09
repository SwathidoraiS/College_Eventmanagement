<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>About - College Event Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background-color: #0a0f0d;
      color: white;
    }

    #tsparticles {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .container {
      position: relative;
      z-index: 1;
      max-width: 850px;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 40px;
      margin-top: 60px;
      border-radius: 15px;
      box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
    }

    .highlight {
      color: #00ff88;
      font-weight: bold;
      font-size: 35px;
    }

    .section-title {
      color: #00ff88;
      font-weight: 700;
      margin-top: 40px;
      font-size: 28px; 
    }

    .btn-home {
      margin-top: 30px;
      border: 1px solid #00ff88;
      color: #00ff88;
    }

    .btn-home:hover {
      background-color: #00ff88;
      color: black;
    }
  </style>
</head>
<body>

<!-- Floating particles background -->
<div id="tsparticles"></div>

<div class="container text-center">
  <h1 class="mb-4 highlight">About Our College</h1>

  <p><strong>
    Malankara Catholic College is administered by the Diocese of Marthandam with the approval of the Govt. of Tamil Nadu, and is affiliated to Manonmaniam Sundaranar University, Tirunelveli. With the guidance of these visionary leaders, we remain committed to empowering students and providing a nurturing environment for growth and learning.
  </strong></p>

  <h3 class="section-title">Vision</h3>
  <p><strong>Transformation of Society through Human Resources.</strong></p>

  <h3 class="section-title">Mission</h3>
  <p><strong>Excellence in Value Based Education and Research for the Development of Human Resources.</strong></p>

  <h3 class="section-title">Motto</h3>
  <p><strong>"LEARN TO SERVE"</strong></p>

  <a href="index.php" class="btn btn-home">← Back to Home</a>
</div>

<script>
  tsParticles.load("tsparticles", {
    fullScreen: { enable: false },
    background: { color: "transparent" },
    particles: {
      number: { value: 100, density: { enable: true, area: 1500 } },
      color: { value: "#00ff88" },
      shape: { type: "circle" },
      opacity: { value: 1.0 },
      size: { value: 2 },
      move: { enable: true, speed: 1, direction: "none", random: false, straight: false }
    },
    interactivity: {
      events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" } },
      modes: {
        repulse: { distance: 100, duration: 0.4 },
        push: { quantity: 4 }
      }
    },
    detectRetina: true
  });
</script>

</body>
</html>
