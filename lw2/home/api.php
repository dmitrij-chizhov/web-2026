<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../data/db.php';

header('Content-Type: application/json');
define('UPLOAD_DIR', '../images/');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(['status' => 'error', 'message' => 'Метод не разрешен. Используйте POST.']);
    exit;
}
if (!is_dir(UPLOAD_DIR)) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Директория для загрузок не существует.']);
    exit;
}
if (!is_writable(UPLOAD_DIR)) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Директория для загрузок не доступна для записи.']);
    exit;
}

$conn->autocommit(FALSE);

try {
    $title = $_POST['title'] ?? null;
    $content = $_POST['content'] ?? null;
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;

    if (!$title || !$user_id) {
        throw new Exception('Некорректные данные: title и user_id обязательны.', 400);
    }

    $sql_post = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    $stmt_post = $conn->prepare($sql_post);
    if (!$stmt_post) throw new Exception("Ошибка подготовки запроса (posts): " . $conn->error);
    
    $stmt_post->bind_param('iss', $user_id, $title, $content);
    if (!$stmt_post->execute()) throw new Exception("Ошибка выполнения запроса (posts): " . $stmt_post->error);

    $new_post_id = $conn->insert_id;
    if (!$new_post_id) throw new Exception("Не удалось получить ID нового поста.");
    
    $stmt_post->close();

    $uploaded_images = []; 
    
    if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
        
        $sql_images = "INSERT INTO post_images (post_id, image_url, display_order) VALUES (?, ?, ?)";
        $stmt_images = $conn->prepare($sql_images);
        if (!$stmt_images) throw new Exception("Ошибка подготовки запроса (post_images): " . $conn->error);

        $image_count = count($_FILES['images']['name']);

        for ($i = 0; $i < $image_count; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                
                $tmp_name = $_FILES['images']['tmp_name'][$i];
                $file_name = uniqid() . '-' . basename($_FILES['images']['name'][$i]);
                $destination = UPLOAD_DIR . $file_name;

                if (move_uploaded_file($tmp_name, $destination)) {
                    $display_order = $i; 
                    
                    $stmt_images->bind_param('isi', $new_post_id, $destination, $display_order);
                    if (!$stmt_images->execute()) throw new Exception("Ошибка сохранения картинки в БД: " . $stmt_images->error);

                    $uploaded_images[] = $destination; 
                } else {
                    throw new Exception("Ошибка перемещения загруженного файла: " . $file_name);
                }
            }
        }
        $stmt_images->close();
    }

    $conn->commit();

    http_response_code(201); 
    echo json_encode([
        'status' => 'success',
        'message' => 'Пост и ' . count($uploaded_images) . ' изображений успешно созданы!',
        'post_id' => $new_post_id,
        'image_paths' => $uploaded_images
    ]);

} catch (Exception $e) {
    
    $conn->rollback();

    $error_code = $e->getCode() ?: 500; 
    http_response_code($error_code);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);

} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>