<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: club_home.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "No account found. Please sign up first.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background-color: #f1f6ff; text-align: center; }
        .box { width: 350px; margin: 120px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px gray; }
        input { width: 90%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background-color: #0066ff; color: white; border: none; border-radius: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="box">
<h2>Login</h2>

<?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<p>Don’t have an account? <a href="signup.php">Sign Up</a></p>
</div>
</body>
</html>
