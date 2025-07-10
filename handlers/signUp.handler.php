<?php
session_start();
require_once __DIR__ . '/../utils/envSetter.util.php';
require_once __DIR__ . '/../utils/auth.util.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input data
    $username = sanitizeInput($_POST['username'] ?? '');
    $firstname = sanitizeInput($_POST['firstname'] ?? '');
    $middlename = sanitizeInput($_POST['middlename'] ?? '');
    $lastname = sanitizeInput($_POST['lastname'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = sanitizeInput($_POST['role'] ?? 'user');
    
    // Validation
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($firstname)) {
        $errors[] = "First name is required";
    }
    
    if (empty($lastname)) {
        $errors[] = "Last name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!isValidEmail($email)) {
        $errors[] = "Please enter a valid email address";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    
    // Check if username or email already exists
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
            
            // Check if username exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Username already exists";
            }
            
            // Check if email exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email already exists";
            }
            
            // If no errors, create user
            if (empty($errors)) {
                $hashedPassword = hashPassword($password);
                
                $stmt = $pdo->prepare("
                    INSERT INTO users (username, firstname, middlename, lastname, email, password, role) 
                    VALUES (:username, :firstname, :middlename, :lastname, :email, :password, :role)
                ");
                
                $stmt->execute([
                    ':username' => $username,
                    ':firstname' => $firstname,
                    ':middlename' => $middlename,
                    ':lastname' => $lastname,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':role' => $role
                ]);
                
                $success = true;
                setFlashMessage('success', 'Account created successfully! You can now log in.');
            }
            
        } catch (Exception $e) {
            // Log the actual error for developers but don't show it to users
            error_log("Sign-up database error: " . $e->getMessage());
            $errors[] = "An error occurred while creating your account. Please try again.";
        }
    }
}
?>
