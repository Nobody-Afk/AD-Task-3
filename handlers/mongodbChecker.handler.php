<?php
require_once __DIR__ . '/../utils/envSetter.util.php';

$host = env('MONGO_HOST', 'localhost');
$port = env('MONGO_PORT', '27112');
$db   = env('MONGO_DB', 'mongodatabase');
try {
    $mongo = new MongoDB\Driver\Manager("mongodb://$host:$port");

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully.  <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}
