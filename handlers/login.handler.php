<?php
session_start();
require_once __DIR__ . '/../utils/envSetter.util.php';
require_once __DIR__ . '/../utils/auth.util.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    if (empty($errors)) {
        try {
            $host = env('POSTGRES_HOST');
            $port = env('POSTGRES_PORT');
            $dbname = env('POSTGRES_DB');
            $user = env('POSTGRES_USER');
            $dbPassword = env('POSTGRES_PASSWORD');
            
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $pdo = new PDO($dsn, $user, $dbPassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userData && verifyPassword($password, $userData['password'])) {
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['username'];
                $_SESSION['role'] = $userData['role'] ?? 'user';
                
                setFlashMessage('success', 'Login successful! Welcome back, ' . $userData['firstname']);
                redirectTo('/pages/Dashboard');
            } else {
                $errors[] = "Invalid username or password";
            }
            
        } catch (Exception $e) {
            // Log the actual error for developers but don't show it to users
            error_log("Login database error: " . $e->getMessage());
            $errors[] = "Login system is temporarily unavailable. Please try again later.";
        }
    }
}
?>
