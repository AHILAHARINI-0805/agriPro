<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// PHP Code to handle signup logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Connection to the database
        $conn = new mysqli('localhost', 'root', '', 'project');

        // Check if the connection is successful
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Check if the email already exists
        $sql = "SELECT email FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email already exists.";
        } else {
            // Insert new user into the database
            $password_hash = password_hash($password, PASSWORD_BCRYPT); // Hash the password
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $email, $password_hash);

            if ($stmt->execute()) {
                $_SESSION['email'] = $email;
                header("Location: home.php");
                exit();
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <style>
        body {
            background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20210902/pngtree-agricultural-science-and-technology-farmland-blue-science-and-technology-background-image_785923.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
           // background-color:pink;
        }
        .signup-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .signup-container h2 {
            margin-bottom: 20px;
        }
        .signup-container input[type="email"], .signup-container input[type="password"] {
            width: calc(100% - 22px); /* Adjusted for padding and border */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .signup-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background: #007bff;
            color: white;
            cursor: pointer;
        }
        .signup-container input[type="submit"]:hover {
            background: #0056b3;
        }
        .error-message {
            color: red;
            margin: 10px 0;
        }
        .login-link {
            margin-top: 20px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php } ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="email" name="email" placeholder="Email ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" name="signup" value="Sign Up">
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
