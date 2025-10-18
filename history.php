<?php
session_start();
include 'db.php';

// Simulate logged-in user
$user_id = $_SESSION['user_id'] ?? 1;

// Fetch username for greeting (optional)
$stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$username = $user['username'] ?? "User";

// Fetch food history
$stmt = $conn->prepare("SELECT * FROM food WHERE user_id=? ORDER BY entry_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Calorie Tracker - History</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
</head>
<body>

<!-- Header -->
<div id="header-placeholder"></div>

<main class="main-container">
    <section class="welcome-message">
        <h1><?php echo htmlspecialchars($username); ?>'s Food History</h1>
        <p>All logged meals and macros</p>
    </section>

    <div class="card">
        <h2>Logged Foods</h2>
        <?php if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <tr>
                    <th>Date</th>
                    <th>Food</th>
                    <th>Calories</th>
                    <th>Protein (g)</th>
                    <th>Carbs (g)</th>
                    <th>Fats (g)</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['entry_date']; ?></td>
                        <td><?php echo htmlspecialchars($row['food_name']); ?></td>
                        <td><?php echo $row['calories']; ?></td>
                        <td><?php echo $row['protein']; ?></td>
                        <td><?php echo $row['carbs']; ?></td>
                        <td><?php echo $row['fats']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center; padding:20px; font-weight:bold;">No meals logged yet.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Footer -->
<div id="footer-placeholder"></div>

<script src="main.js"></script>
</body>
</html>
