<?php
// save_form.php - обработчик формы
require_once 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Обработка preflight запроса CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Получаем данные
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Данные не получены']);
    exit;
}

// Валидация
if (empty($data['name'])) {
    echo json_encode(['success' => false, 'message' => 'Имя обязательно']);
    exit;
}

if (!isset($data['guestsCount']) || !is_numeric($data['guestsCount'])) {
    echo json_encode(['success' => false, 'message' => 'Количество гостей должно быть числом']);
    exit;
}

if (empty($data['selectedOption']) || $data['selectedOption'] === 'не выбрано') {
    echo json_encode(['success' => false, 'message' => 'Выберите вариант']);
    exit;
}

try {
    // Очищаем имя
    $cleanName = trim($data['name']);
    $cleanName = preg_replace('/\s+/', ' ', $cleanName);
    
    // Проверяем существование имени
    $checkStmt = $pdo->prepare("SELECT id FROM form_submissions WHERE LOWER(name) = LOWER(?)");
    $checkStmt->execute([$cleanName]);
    $existing = $checkStmt->fetch();
    
    if ($existing) {
        // Обновляем существующую запись
        $stmt = $pdo->prepare("UPDATE form_submissions SET guests_count = ?, selected_option = ?, all_radios = ? WHERE id = ?");
        $stmt->execute([
            $data['guestsCount'],
            $data['selectedOption'],
            json_encode($data['allRadios'], JSON_UNESCAPED_UNICODE),
            $existing['id']
        ]);
        
        echo json_encode([
            'success' => true,
            'action' => 'updated',
            'message' => 'Данные обновлены',
            'id' => $existing['id']
        ]);
    } else {
        // Создаем новую запись
        $stmt = $pdo->prepare("INSERT INTO form_submissions (name, guests_count, selected_option, all_radios) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $cleanName,
            $data['guestsCount'],
            $data['selectedOption'],
            json_encode($data['allRadios'], JSON_UNESCAPED_UNICODE)
        ]);
        
        echo json_encode([
            'success' => true,
            'action' => 'inserted',
            'message' => 'Новая запись создана',
            'id' => $pdo->lastInsertId()
        ]);
    }
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Ошибка: ' . $e->getMessage()
    ]);
}
?>