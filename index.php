<?php
session_start();
include 'db.php';

// Simulate logged-in user (replace with real session later)
$user_id = $_SESSION['user_id'] ?? 1;

// Fetch username from users table
$stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$username = $user['username'] ?? "User"; // fallback if not found

// NEW: Function to calculate daily calorie needs

function calculateDailyCalories($conn, $user_id) {
    // 1. Fetch user's physical info
    $stmt = $conn->prepare("SELECT age, height, weight, gender, goal_type FROM userinfo WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        return 2000; // Fallback to default if no info found
    }
    $info = $result->fetch_assoc();

    // 2. Calculate BMR using Mifflin-St Jeor equation
    $bmr = 0;
    if ($info['gender'] == 'male') {
        $bmr = (10 * $info['weight']) + (6.25 * $info['height']) - (5 * $info['age']) + 5;
    } else { // female
        $bmr = (10 * $info['weight']) + (6.25 * $info['height']) - (5 * $info['age']) - 161;
    }

    // 3. Calculate TDEE (maintenance calories) - assuming lightly active for now
    $activity_multiplier = 1.375;
    $maintenance_calories = $bmr * $activity_multiplier;

    // 4. Adjust calories based on goal
    $goal_calories = $maintenance_calories;
    if ($info['goal_type'] == 'gain') {
        $goal_calories += 300;
    } elseif ($info['goal_type'] == 'lose') {
        $goal_calories -= 300;
    }

    return round($goal_calories);
}

// End of new function

// MODIFIED: Get the user's calculated calorie goal first
$user_calorie_goal = calculateDailyCalories($conn, $user_id);

// Handle adding food
if (isset($_POST['add_food'])) {
    // ... (rest of the add_food logic is unchanged)
    $food_name_searched = $_POST['food_name'];
    $quantity = (int) $_POST['quantity'];
    if ($quantity < 1) $quantity = 1;

    $stmt = $conn->prepare("SELECT calories, protein, carbs, fats FROM food_library WHERE food_name = ?");
    $stmt->bind_param("s", $food_name_searched);
    $stmt->execute();
    $food_data_result = $stmt->get_result();

    if ($food_data_result->num_rows > 0) {
        $food_data = $food_data_result->fetch_assoc();
        $calories = $food_data['calories'] * $quantity;
        $protein = $food_data['protein'] * $quantity;
        $carbs = $food_data['carbs'] * $quantity;
        $fats = $food_data['fats'] * $quantity;
        $logged_food_name = $food_name_searched . " (x" . $quantity . ")";
        $stmt = $conn->prepare("INSERT INTO food (user_id, food_name, calories, protein, carbs, fats, entry_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("isiiii", $user_id, $logged_food_name, $calories, $protein, $carbs, $fats);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT id FROM daily_totals WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO daily_totals (user_id, total_calories) VALUES (?, ?)");
            $stmt->bind_param("ii", $user_id, $user_calorie_goal);
            $stmt->execute();
        }

        $stmt = $conn->prepare("UPDATE daily_totals SET total_calories = total_calories - ?, total_protein = total_protein + ?, total_carbs = total_carbs + ?, total_fats = total_fats + ? WHERE user_id=?");
        $stmt->bind_param("iiiii", $calories, $protein, $carbs, $fats, $user_id);
        $stmt->execute();
    }
}

// Handle reset
if (isset($_POST['reset'])) {
    // Resets the daily totals without deleting food history
    $stmt = $conn->prepare("UPDATE daily_totals SET total_calories=?, total_protein=0, total_carbs=0, total_fats=0 WHERE user_id=?");
    $stmt->bind_param("ii", $user_calorie_goal, $user_id);
    $stmt->execute();
}

// Fetch daily totals
$stmt = $conn->prepare("SELECT * FROM daily_totals WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$totals = $result->fetch_assoc();

// If no totals row exists for the user, create a default one
if (!$totals) {
    $stmt = $conn->prepare("INSERT INTO daily_totals (user_id, total_calories, total_protein, total_carbs, total_fats) VALUES (?, ?, 0, 0, 0)");
    $stmt->bind_param("ii", $user_id, $user_calorie_goal);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM daily_totals WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $totals = $stmt->get_result()->fetch_assoc();
}

// Fetch all food names for the search dropdown
$food_list_result = $conn->query("SELECT food_name FROM food_library ORDER BY food_name ASC");

// =================================================================
// NEW: Fetch today's food log
// =================================================================
$stmt = $conn->prepare("SELECT food_name, calories FROM food WHERE user_id = ? AND DATE(entry_date) = CURDATE() ORDER BY entry_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$todays_food_result = $stmt->get_result();
// =================================================================

?>
<!DOCTYPE html>
<html>
<head>
    <title>Calorie Tracker - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="header-placeholder"></div>

<main class="main-container">
    <section class="welcome-message">
        <h1>Welcome <?php echo htmlspecialchars($username); ?></h1>
        <h3>Your daily nutrition progress</h3>
    </section>

    <div class="card">
        <h2>Daily Totals</h2>
        <div class="calories-display">
            <div class="calories-text">
                <?php echo $totals['total_calories']; ?> <span>kcal remaining</span>
            </div>
        </div>
        <div class="macros">
            <div class="macro-item">
                <h4>Protein</h4>
                <p><?php echo $totals['total_protein']; ?> g</p>
            </div>
            <div class="macro-item">
                <h4>Carbs</h4>
                <p><?php echo $totals['total_carbs']; ?> g</p>
            </div>
            <div class="macro-item">
                <h4>Fats</h4>
                <p><?php echo $totals['total_fats']; ?> g</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Add Food</h2>
        <form method="post" class="add-food-form">
            <div class="form-row">
                <div class="input-group search-group">
                    <label for="food_name_input">Food Name</label>
                    <input id="food_name_input" list="food-list" name="food_name" placeholder="Search for food..." required>
                    <datalist id="food-list">
                        <?php
                        if ($food_list_result->num_rows > 0) {
                            while($row = $food_list_result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['food_name']) . '">';
                            }
                        }
                        ?>
                    </datalist>
                </div>
                <div class="input-group quantity-group">
                    <label for="quantity_input">Qty</label>
                    <input id="quantity_input" type="number" name="quantity" value="1" min="1" required>
                </div>
            </div>
            <button class="button" type="submit" name="add_food">Add Food</button>
        </form>
    </div>

    <div class="card">
        <h2>Today's Log</h2>
        <?php if ($todays_food_result->num_rows > 0): ?>
            <ul class="todays-meals-list">
                <?php while($food_item = $todays_food_result->fetch_assoc()): ?>
                    <li class="meal-item">
                        <span><?php echo htmlspecialchars($food_item['food_name']); ?></span>
                        <span class="meal-calories"><?php echo $food_item['calories']; ?> kcal</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No food logged yet today.</p>
        <?php endif; ?>
    </div>
    <form method="post">
        <button class="cta-button" type="submit" name="reset">Reset Daily Totals</button>
    </form>

</main>

<div id="footer-placeholder"></div>

<script src="main.js"></script>
</body>
</html>