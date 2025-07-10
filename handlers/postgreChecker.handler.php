<?php
require_once __DIR__ . '/../utils/envSetter.util.php';

$host     = env('POSTGRES_HOST', 'localhost');
$port     = env('POSTGRES_PORT', '5432');
$dbname   = env('POSTGRES_DB', 'postgredatabase');
$user     = env('POSTGRES_USER', 'user');
$password = env('POSTGRES_PASSWORD', 'password');

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: " . (pg_last_error() ?: "Unable to connect") . "  <br>";
    exit();
} else {
    echo "✔️ PostgreSQL Connection  <br>";
    pg_close($dbconn);
}