<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIWES Application</title>
  <style>
    /* Global Styles */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
    }
    .btn {
      background: #007BFF;
      color: #fff;
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .btn:hover {
      background: #0056b3;
    }
    /* Landing Section */
    .hero {
      height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
        url('https://source.unsplash.com/featured/?university');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      padding: 20px;
    }
    .hero h1 {
      font-size: 3rem;
      margin-bottom: 20px;
    }
    .hero p {
      font-size: 1.2rem;
      margin-bottom: 40px;
      max-width: 600px;
    }
    /* Modal Styles */
    .modal {
      display: none; /* Hidden by default */
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.6);
      padding-top: 50px;
    }
    .modal-content {
      background-color: #fff;
      margin: auto;
      border-radius: 8px;
      padding: 20px;
      width: 90%;
      max-width: 500px;
      position: relative;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
    }
    /* Form Styles */
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .description {
      font-size: 0.9rem;
      color: #666;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <!-- Landing Section -->
  <div class="hero">
    <h1>Welcome to SIWES Application</h1>
    <p>
      Apply online for the Student Industrial Work Experience Scheme (SIWES)
      at the Computer Engineering Department, Ahmadu Bello University, Zaria.
    </p>
    <button class="btn" id="getStartedBtn">Get Started</button>
  </div>

  <!-- Modal with Application Form -->
  <div id="applicationModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeModal">&times;</span>
      <h2>SIWES Application Form</h2>
      <form id="applicationForm" action="submit.php" method="POST">
        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" id="fullName" name="fullName" required />
        </div>
        <div class="form-group">
          <label for="school">Your School</label>
          <input type="text" id="school" name="school" required />
        </div>
        <div class="form-group">
          <label for="department">Your Department</label>
          <input type="text" id="department" name="department" required />
        </div>
        <div class="form-group">
          <label for="cgpa">Your CGPA</label>
          <input type="number" step="0.01" id="cgpa" name="cgpa" min="0" max="5" required />
        </div>
        <div class="form-group">
          <label for="age">Your Age</label>
          <input type="number" id="age" name="age" min="16" required />
        </div>
        <div class="form-group">
          <label for="department">Email</label>
          <input type="text" id="email" name="email" required />
        </div>
        <div class="form-group">
          <label for="siwesType">Type of SIWES</label>
          <select id="siwesType" name="siwesType" required>
            <option value="" disabled selected>Select a type</option>
            <option value="AI">AI</option>
            <option value="Network">Network and Security</option>
            <option value="System">System Control</option>
          </select>
          <div id="siwesDescription" class="description"></div>
        </div>
        <div class="form-group">
          <label for="reason">State Reason for Joining Siwes</label>
          <input type="text" id="reason" name="reason" min="16" required />
        </div>
        <button type="submit" class="btn">Submit Application</button>
      </form>
    </div>
  </div>

  <script>
    // Modal Logic
    const modal = document.getElementById("applicationModal");
    const getStartedBtn = document.getElementById("getStartedBtn");
    const closeModal = document.getElementById("closeModal");

    getStartedBtn.onclick = () => {
      modal.style.display = "block";
    };

    closeModal.onclick = () => {
      modal.style.display = "none";
    };

    window.onclick = (event) => {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };

    // Dropdown Description Logic
    const siwesType = document.getElementById("siwesType");
    const siwesDescription = document.getElementById("siwesDescription");

    const descriptions = {
      AI: "Focus on Artificial Intelligence technologies, including machine learning, neural networks, and data analysis.",
      Network:
        "Explore Network and Security concepts, learning about cybersecurity, network protocols, and system defenses.",
      System:
        "Delve into System Control, focusing on embedded systems, control theory, and automation."
    };

    siwesType.addEventListener("change", () => {
      const selected = siwesType.value;
      siwesDescription.textContent = descriptions[selected] || "";
    });
  </script>
</body>
</html>
