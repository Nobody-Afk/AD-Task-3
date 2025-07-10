<?php
session_start();
require_once __DIR__ . '/utils/auth.util.php';

$isLoggedIn = isLoggedIn();
$currentUser = $isLoggedIn ? getCurrentUser() : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + Database Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .welcome-message {
            margin-bottom: 30px;
            color: #666;
        }
        .nav-links {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .nav-links a {
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .nav-links a:hover {
            background-color: #0056b3;
        }
        .nav-links .divider {
            color: #666;
            font-weight: bold;
        }
        .success-message {
            background: #e6ffe6;
            color: #4f8a10;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            border: 1px solid #4f8a10;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP + Database Project</h1>
        
        <?php if ($isLoggedIn): ?>
            <div class="welcome-message">
                <p>Welcome, <?php echo htmlspecialchars($currentUser['firstname']); ?>!</p>
            </div>
            <div class="nav-links">
                <a href="/pages/Dashboard">Dashboard</a>
                <a href="/handlers/logout.handler.php">Logout</a>
            </div>
        <?php else: ?>
            <div class="welcome-message">
                <p>Please log in or create a new account to continue.</p>
            </div>
            <div class="nav-links">
                <a href="/pages/Login">Login</a>
                <span class="divider">OR</span>
                <a href="/pages/SignUp">Sign Up</a>
            </div>
        <?php endif; ?>
        
        <?php 
        $successMessage = getFlashMessage('success');
        if ($successMessage): 
        ?>
            <div class="success-message">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>