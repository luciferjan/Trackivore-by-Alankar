<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve POST data
    $user_id     = $_POST['user_id'];
    $fullname    = $_POST['fullname'];
    $phone       = $_POST['phone'];
    $age         = $_POST['age'];
    $height      = $_POST['height']; // cm
    $weight      = $_POST['weight']; // kg
    $bmi         = $_POST['bmi'];    // from form
    $goal_weight = $_POST['goal_weight'];
    $goal_type   = $_POST['goal_type'];

    // Save to database
    $stmt = $conn->prepare("INSERT INTO userinfo (user_id, fullname, phone, age, height, weight, bmi, goal_weight, goal_type) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issidddds", $user_id, $fullname, $phone, $age, $height, $weight, $bmi, $goal_weight, $goal_type);

    if ($stmt->execute()) {
        // Redirect to login page after saving
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complete Your Profile</title>
  <style>
    :root {
      --background-primary: #161b22;
      --background-secondary: #0d1117;
      --accent-primary: #38b6ff;
      --accent-secondary: #0077b6;
      --accent-light: #a2d2ff;
      --text-primary: #f0f6fc;
      --text-secondary: #8b949e;

      --background-primary-rgb: 22, 27, 34;
      --accent-primary-rgb: 56, 182, 255;
      --text-secondary-rgb: 139, 148, 158;

      --border-color: rgba(var(--text-secondary-rgb), 0.2);
      --transition-speed: 0.3s ease;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
      background: linear-gradient(-45deg, var(--background-secondary), var(--accent-secondary), var(--background-secondary), var(--background-primary));
      background-size: 400% 400%;
      animation: gradientBG 20s ease infinite;
      color: var(--text-primary);
      margin: 0;
      padding: 2rem 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .profile-form-card {
      width: 100%;
      max-width: 450px;
      background: rgba(var(--background-primary-rgb), 0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }

    h2 {
      text-align: center;
      color: var(--accent-light);
      margin-top: 0;
      margin-bottom: 1.5rem;
      font-weight: 700;
    }

    /* --- Form Elements --- */
    .form-group {
      margin-bottom: 1.2rem;
    }

    label {
      display: block;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--text-secondary);
      margin-bottom: 0.5rem;
    }
    
    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 0.9rem 1rem;
      background-color: var(--background-secondary);
      border: 1px solid var(--border-color);
      border-radius: 10px;
      color: var(--text-primary);
      font-size: 1rem;
      transition: border-color var(--transition-speed), box-shadow var(--transition-speed);
      box-sizing: border-box; /* Important for consistent sizing */
    }

    input:focus, select:focus {
      outline: none;
      border-color: var(--accent-primary);
      box-shadow: 0 0 0 4px rgba(var(--accent-primary-rgb), 0.25);
    }

    input::placeholder {
      color: var(--text-secondary);
      opacity: 0.7;
    }
    
    /* Remove number input spinners */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* --- BMI Result --- */
    #bmiCategory {
      font-size: 0.9rem;
      margin-top: 0.5rem;
      color: var(--text-secondary);
      text-align: right;
    }

    /* --- Button --- */
    .form-submit-button {
      display: block;
      width: 100%;
      padding: 1rem;
      margin-top: 1.5rem;
      background: linear-gradient(45deg, var(--accent-secondary) 0%, var(--accent-primary) 100%);
      color: var(--text-primary);
      text-align: center;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      transition: all var(--transition-speed);
    }

    .form-submit-button:hover {
      background: linear-gradient(45deg, var(--accent-primary) 0%, var(--accent-light) 100%);
      color: var(--background-secondary);
      box-shadow: 0 6px 20px rgba(var(--accent-primary-rgb), 0.4);
    }
  </style>
</head>
<body>
  <div class="profile-form-card">
    <h2>Complete Your Profile</h2>
    <form method="POST">

      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
      </div>
      
      <div class="form-group">
        <label for="age">Age</label>
        <input type="number" id="age" name="age" placeholder="Enter your age" required>
      </div>

      <div class="form-group">
        <label for="height">Height (cm)</label>
        <input type="number" step="0.1" id="height" name="height" placeholder="e.g., 175.5" required>
      </div>
      
      <div class="form-group">
        <label for="weight">Weight (kg)</label>
        <input type="number" step="0.1" id="weight" name="weight" placeholder="e.g., 70.2" required>
      </div>

      <div class="form-group">
        <label for="bmi">Your BMI</label>
        <input type="text" id="bmi" name="bmi" placeholder="Calculated automatically" readonly>
        <div id="bmiCategory"></div>
      </div>
      
      <div class="form-group">
        <label for="goal_weight">Goal Weight (kg)</label>
        <input type="number" step="0.1" id="goal_weight" name="goal_weight" placeholder="e.g., 65" required>
      </div>

      <div class="form-group">
        <label for="goal_type">Primary Goal</label>
        <select id="goal_type" name="goal_type" required>
          <option value="fat_loss">Fat Loss</option>
          <option value="gain">Weight Gain</option>
          <option value="maintain">Maintain Weight</option>
        </select>
      </div>
      
      <button type="submit" class="form-submit-button">Save Profile</button>
    </form>
  </div>

  <script>
    function calculateBMI() {
      const heightInput = document.getElementById("height");
      const weightInput = document.getElementById("weight");
      const bmiInput = document.getElementById("bmi");
      const categoryDiv = document.getElementById("bmiCategory");

      let height = parseFloat(heightInput.value);
      let weight = parseFloat(weightInput.value);

      if (height > 0 && weight > 0) {
        let bmi = (weight / ((height / 100) ** 2)).toFixed(2);
        bmiInput.value = bmi;

        let category = "";
        if (bmi < 18.5) category = "Underweight";
        else if (bmi < 25) category = "Normal weight";
        else if (bmi < 30) category = "Overweight";
        else category = "Obese";

        categoryDiv.textContent = "Category: " + category;
      } else {
        bmiInput.value = "";
        categoryDiv.textContent = "";
      }
    }

    document.getElementById("height").addEventListener("input", calculateBMI);
    document.getElementById("weight").addEventListener("input", calculateBMI);
  </script>
</body>
</html>