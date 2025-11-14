<!DOCTYPE html>
<html>
<head>
    <title>Club Management System</title>

    <style>
        * { margin: 0; padding: 0; font-family: Arial; }

        body {
            background: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)),
                        url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .box {
            width: 400px;
            text-align: center;
            padding: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }

        h1 { font-size: 32px; margin-bottom: 20px; }

        .btn {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 12px;
            border-radius: 8px;
            background: #0066ff;
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: 0.3s;
        }

        .btn:hover { background: #004bcc; }
    </style>
</head>

<body>

<div class="box">
    <h1>Club Management System</h1>
    <a href="index.php" class="btn">Login</a>
    <a href="signup.php" class="btn">Register</a>
</div>

</body>
</html>
