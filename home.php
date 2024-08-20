<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php?message=Logged out successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20210902/pngtree-agricultural-science-and-technology-farmland-blue-science-and-technology-background-image_785923.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        .home-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
        }

        .home-container h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        .home-container p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #333;
        }

        .home-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff7e5f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .home-container a:hover {
            background-color: #feb47b;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h1>Welcome to AgriPro</h1>
        <p>You are logged in as <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <a href="?logout=true">Logout</a>
    </div>
</body>
</html>
