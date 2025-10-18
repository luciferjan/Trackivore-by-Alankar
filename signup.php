<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username exists
    $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        echo "Username already exists!";
        exit;
    }

    // Insert user into users table
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $user_id = $stmt->insert_id;

    // Redirect to userinfo page
    echo "<script>window.location.href='userinfo.php?user_id=$user_id';</script>";
}
?>
