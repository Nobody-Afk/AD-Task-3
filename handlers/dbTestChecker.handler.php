<?php
require_once __DIR__ . '/../utils/envSetter.util.php';

$host = env('POSTGRES_HOST', 'localhost');
$port = env('POSTGRES_PORT', '5432');
$dbname = env('POSTGRES_DB', 'postgredatabase');
$user = env('POSTGRES_USER', 'user');
$password = env('POSTGRES_PASSWORD', 'password');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "✅ Connected to PostgreSQL successfully<br>";
    
    // Check if tables exist
    $tables = ['users', 'projects', 'tasks', 'project_users'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$table'");
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            echo "✅ Table '$table' exists<br>";
        } else {
            echo "❌ Table '$table' does not exist<br>";
        }
    }
    
    // Check if data exists in users table
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();
    echo "👥 Users in database: $userCount<br>";
    
    if ($userCount > 0) {
        echo "<h3>Sample Users:</h3>";
        $stmt = $pdo->query("SELECT username, firstname, lastname, email FROM users LIMIT 5");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['username']} ({$row['firstname']} {$row['lastname']}) - Email: {$row['email']}<br>";
        }
    }
    
    // Check projects
    $stmt = $pdo->query("SELECT COUNT(*) FROM projects");
    $projectCount = $stmt->fetchColumn();
    echo "<br>📁 Projects in database: $projectCount<br>";
    
    if ($projectCount > 0) {
        echo "<h3>Sample Projects:</h3>";
        $stmt = $pdo->query("SELECT name, description FROM projects LIMIT 5");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['name']}: {$row['description']}<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}
?>
