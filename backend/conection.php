<?php
// connection.php - подключение к базе данных

$servername = "localhost";
$username = "root";
$password1 = "";
$database = "hopar";

// $servername = "localhost";
// $username = "nareks5k_5";
// $password1 = "nareks5k_55";
// $database = "nareks5k_5";

try {
    $dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password1, $options);
} catch (PDOException $e) {
    die(json_encode([
        'success' => false,
        'message' => 'Ошибка подключения к БД: ' . $e->getMessage()
    ]));
}
?>