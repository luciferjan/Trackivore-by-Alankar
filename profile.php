<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT fullname, phone, age, height, weight, bmi, goal_weight, goal_type 
        FROM userinfo WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trackivore - Your Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header -->
    <div id="header-placeholder"></div>

    <main class="main-container">

        <!-- Welcome Section -->
        <div class="welcome-message">
            <h1>Hello, <?php echo htmlspecialchars($user['fullname']); ?>!</h1>
        </div>

        <!-- Profile Info Card -->
        <section class="card profile-card">
            <h2 class="card-title">Personal Information</h2>

            <div class="form-group">
                <label>Full Name</label>
                <p><?php echo htmlspecialchars($user['fullname']); ?></p>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <p><?php echo htmlspecialchars($user['phone']); ?></p>
            </div>

            <div class="form-group">
                <label>Age</label>
                <p><?php echo htmlspecialchars($user['age']); ?> years</p>
            </div>

            <h2 class="card-title">Body Stats</h2>

            <div class="form-group">
                <label>Height</label>
                <p><?php echo htmlspecialchars($user['height']); ?> cm</p>
            </div>

            <div class="form-group">
                <label>Weight</label>
                <p><?php echo htmlspecialchars($user['weight']); ?> kg</p>
            </div>

            <div class="form-group">
                <label>BMI</label>
                <p><?php echo htmlspecialchars($user['bmi']); ?></p>
            </div>

            <h2 class="card-title">Fitness Goals</h2>

            <div class="form-group">
                <label>Goal Weight</label>
                <p><?php echo htmlspecialchars($user['goal_weight']); ?> kg</p>
            </div>

            <div class="form-group">
                <label>Goal Type</label>
                <p>
                    <?php
                        if ($user['goal_type'] === "gain") echo "Weight Gain";
                        elseif ($user['goal_type'] === "fat_loss") echo "Fat Loss";
                        else echo "Maintain Current Weight";
                    ?>
                </p>
            </div>

            <!-- Edit Profile Button -->
            <div class="form-group">
                <a href="userinfo.php?user_id=<?php echo $user_id; ?>" class="cta-button">
                    Edit Profile
                </a>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <div id="footer-placeholder"></div>

    <script src="main.js"></script>
</body>
</html>
