<?php
// database.php - отдельный файл подключения к БД

// Параметры подключения - ИЗМЕНИТЕ НА СВОИ!
define('DB_HOST', 'localhost');
define('DB_NAME', 'hopar'); // Изменено на ваше имя БД
define('DB_USER', 'root');   // Изменено на вашего пользователя
define('DB_PASS', '');       // Изменено на ваш пароль
define('DB_CHARSET', 'utf8mb4');

/**
 * Функция подключения к базе данных
 * @return PDO
 */
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // В случае ошибки подключения
        die(json_encode([
            'success' => false,
            'message' => 'Ошибка подключения к БД: ' . $e->getMessage()
        ]));
    }
}

/**
 * Функция для проверки подключения
 * @return array
 */
function testConnection() {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->query("SELECT 'Подключение работает' as status");
        return ['success' => true, 'message' => $stmt->fetch()['status']];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
?>