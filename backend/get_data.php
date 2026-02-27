<?php
// get_data.php - получение данных из БД и передача в JS
require_once 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Проверяем существование таблицы
    $pdo->query("SELECT 1 FROM form_submissions LIMIT 1");
    
    // Получаем все записи из таблицы
    $stmt = $pdo->query("SELECT * FROM form_submissions ORDER BY created_at DESC");
    $data = $stmt->fetchAll();
    
    // Форматируем данные
    $formattedData = [];
    foreach ($data as $row) {
        $formattedData[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'guestsCount' => $row['guests_count'],
            'selectedOption' => $row['selected_option'],
            'allRadios' => json_decode($row['all_radios'], true),
            'createdAt' => $row['created_at']
        ];
    }
    
    // Отправляем данные в формате JSON
    echo json_encode([
        'success' => true,
        'count' => count($formattedData),
        'data' => $formattedData
    ]);
    
} catch(PDOException $e) {
    // Проверяем, существует ли таблица
    if ($e->getCode() == '42S02') { // Таблица не существует
        echo json_encode([
            'success' => false,
            'message' => 'Таблица form_submissions не найдена. Создайте её.',
            'error' => $e->getMessage()
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Ошибка: ' . $e->getMessage()
        ]);
    }
}
?>