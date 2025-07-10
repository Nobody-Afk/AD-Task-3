<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Composer bootstrap
require_once 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

// Load dummy data
$users = require_once DUMMIES_PATH . '/users.staticData.php';
$projects = require_once DUMMIES_PATH . '/projects.staticData.php';

$host = env('POSTGRES_HOST');
$port = env('POSTGRES_PORT');
$username = env('POSTGRES_USER');
$password = env('POSTGRES_PASSWORD');
$dbname = env('POSTGRES_DB');

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Connected to PostgreSQL successfully!\n";

// Apply users schema
echo "Applying schema from database/users.model.sql…\n";
$sql = file_get_contents('database/users.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/users.model.sql");
} else {
    echo "Creation Success from the database/users.model.sql\n";
}
$pdo->exec($sql);

// Apply projects schema
echo "Applying schema from database/projects.model.sql…\n";
$sql = file_get_contents('database/projects.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/projects.model.sql");
} else {
    echo "Creation Success from the database/projects.model.sql\n";
}
$pdo->exec($sql);

// Apply tasks schema
echo "Applying schema from database/tasks.model.sql…\n";
$sql = file_get_contents('database/tasks.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/tasks.model.sql");
} else {
    echo "Creation Success from the database/tasks.model.sql\n";
}
$pdo->exec($sql);

// Apply project_users schema
echo "Applying schema from database/project_users.model.sql…\n";
$sql = file_get_contents('database/project_users.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/project_users.model.sql");
} else {
    echo "Creation Success from the database/project_users.model.sql\n";
}
$pdo->exec($sql);

// Seed users
echo "Seeding users…\n";
$stmt = $pdo->prepare("
    INSERT INTO users (username, firstname, middlename, lastname, email, password, role)
    VALUES (:username, :firstname, :middlename, :lastname, :email, :password, :role)
");

foreach ($users as $u) {
    $stmt->execute([
        ':username' => $u['username'],
        ':firstname' => $u['firstname'],
        ':middlename' => $u['middlename'],
        ':lastname' => $u['lastname'],
        ':email' => $u['email'],
        ':password' => password_hash($u['password'], PASSWORD_DEFAULT),
        ':role' => $u['role'] ?? 'user',
    ]);
}

// Seed projects
echo "Seeding projects…\n";
$stmt = $pdo->prepare("
    INSERT INTO projects (name, description)
    VALUES (:name, :description)
");

foreach ($projects as $p) {
    $stmt->execute([
        ':name' => $p['name'],
        ':description' => $p['description'],
    ]);
}

echo "✅ PostgreSQL seeding complete!\n";
