<?php
session_start();
require_once __DIR__ . '/../../utils/envSetter.util.php';
require_once __DIR__ . '/../../utils/auth.util.php';

if (!isLoggedIn()) {
    redirectTo('/pages/Login');
}

$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background-color: #c82333;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($currentUser['firstname'] . ' ' . $currentUser['lastname']); ?></span>
            <a href="/handlers/logout.handler.php" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <div class="welcome-card">
        <h2>Welcome to Your Dashboard</h2>
        <p>Hello <?php echo htmlspecialchars($currentUser['firstname']); ?>! You are successfully logged in.</p>
    </div>
    
    <div class="container">
        <h2>Your Account Information</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($currentUser['username']); ?></p>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($currentUser['firstname'] . ' ' . ($currentUser['middlename'] ? $currentUser['middlename'] . ' ' : '') . $currentUser['lastname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($currentUser['email']); ?></p>
        <p><strong>User ID:</strong> <?php echo htmlspecialchars($currentUser['id']); ?></p>
    </div>
    
    <?php
    // Get some basic stats
    try {
        $host = env('POSTGRES_HOST');
        $port = env('POSTGRES_PORT');
        $dbname = env('POSTGRES_DB');
        $user = env('POSTGRES_USER');
        $password = env('POSTGRES_PASSWORD');
        
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $taskCount = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
    ?>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $userCount; ?></div>
            <div>Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $projectCount; ?></div>
            <div>Total Projects</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $taskCount; ?></div>
            <div>Total Tasks</div>
        </div>
    </div>
    
    <?php
    } catch (Exception $e) {
        echo "<p>Error loading statistics: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</body>
</html>
