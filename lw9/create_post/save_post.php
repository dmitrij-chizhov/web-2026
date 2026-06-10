<?php
ini_set('display_errors', 0);
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
    if (!mkdir(UPLOAD_DIR, 0777, true)) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Директория для загрузок не существует и не может быть создана.']);
        exit;
    }
}

if (!is_writable(UPLOAD_DIR)) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Директория для загрузок не доступна для записи.']);
    exit;
}

$conn->autocommit(FALSE);

try {
    $content = isset($_POST['caption']) ? trim($_POST['caption']) : null;
    $user_id = 1;

    if (empty($content)) {
        throw new Exception('Текст подписи обязателен для заполнения.', 400);
    }

    $stmt_post = $conn->prepare("INSERT INTO posts (content, user_id, like_count, created_time) VALUES (?, ?, 0, NOW())");
    if (!$stmt_post) {
        throw new Exception("Ошибка подготовки запроса поста: " . $conn->error);
    }

    $stmt_post->bind_param('si', $content, $user_id);
    if (!$stmt_post->execute()) {
        throw new Exception("Ошибка сохранения поста: " . $stmt_post->error);
    }

    $new_post_id = $conn->insert_id;
    $stmt_post->close();

    $uploaded_images = [];

    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $stmt_images = $conn->prepare("INSERT INTO post_images (post_id, image_url, display_order) VALUES (?, ?, ?)");
        if (!$stmt_images) {
            throw new Exception("Ошибка подготовки запроса изображений: " . $conn->error);
        }

        $file_count = count($_FILES['images']['name']);

        for ($i = 0; $i < $file_count; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['images']['tmp_name'][$i];
                
                $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                $file_name = uniqid('post_' . $new_post_id . '_', true) . '.' . $extension;
                $destination = UPLOAD_DIR . $file_name;

                if (move_uploaded_file($tmp_name, $destination)) {
                    $display_order = $i; 
                    
                    $db_save_path = 'images/' . $file_name;

                    $stmt_images->bind_param('isi', $new_post_id, $db_save_path, $display_order);
                    if (!$stmt_images->execute()) {
                        throw new Exception("Ошибка сохранения картинки в БД: " . $stmt_images->error);
                    }

                    $uploaded_images[] = $db_save_path; 
                } else {
                    throw new Exception("Ошибка перемещения загруженного файла.");
                }
            } else if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                throw new Exception("Ошибка загрузки одного из файлов под индексом " . $i);
            }
        }
        $stmt_images->close();
    } else {
        throw new Exception('Необходимо добавить хотя бы одно фото.', 400);
    }

    $conn->commit();

    http_response_code(201); 
    echo json_encode([
        'status' => 'success',
        'message' => 'Пост успешно сохранен!'
    ]);
} catch (Exception $e) {
    $conn->rollback();

    $error_code = $e->getCode();
    if ($error_code < 400 || $error_code > 599) {
        $error_code = 500;
    }
    
    http_response_code($error_code); 
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}