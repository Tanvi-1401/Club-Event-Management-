<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role)
            VALUES ('$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created successfully! Please login now.');
        window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Email already exists!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body { font-family: Arial; background-color: #eef3ff; text-align: center; }
        .box { width: 350px; margin: 100px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px gray; }
        input, select { width: 90%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background-color: #0066ff; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>
<div class="box">
<h2>Create Account</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role">
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Sign Up</button>
</form>
<p>Already have an account? <a href="index.php">Login</a></p>
</div>
</body>
</html>
