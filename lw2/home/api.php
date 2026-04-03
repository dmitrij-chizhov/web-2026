<?php
define('UPLOAD_DIR', 'static/');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Метод не разрешен. Используйте POST.'
    ]);
    exit; 
}

$uploadStatus = 'No file uploaded';
$uploadedFilePath = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['image']['tmp_name'];
    
    $fileName = basename(preg_replace("/[^a-zA-Z0-9\.\-\_]/", "", $_FILES['image']['name']));

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid() . '-' . time() . '.' . $fileExtension;

    $destination = UPLOAD_DIR . $uniqueFileName;

    if (move_uploaded_file($tmpName, $destination)) {
        $uploadStatus = 'File uploaded successfully';
        $uploadedFilePath = $destination;
    } else {
        $uploadStatus = 'Error moving uploaded file';
    }
}

$response = [
    'status' => 'success',
    'message' => 'Данные успешно получены.',
    'file_info' => [
        'status' => $uploadStatus,
        'path' => $uploadedFilePath,
        'original_name' => isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null,
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>