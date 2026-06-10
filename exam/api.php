<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once './db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(['status' => 'error', 'message' => 'Метод не разрешен. Используйте POST.']);
    exit;
}

$conn->autocommit(FALSE);

try {
    function bindFaculty($conn) {
        $facultyName = $_POST['faculty_name'] ?? null;

        if (!$facultyName) {
            throw new Exception('Данные: faculty_name обязательны.', 400);
        }

        $sqlFaculty = "INSERT INTO faculty (faculty_name) VALUES (?)";
        $requestFaculty = $conn->prepare($sqlFaculty);
        if (!$requestFaculty) {
            throw new Exception("Ошибка подготовки запроса : " . $conn->error);
        }
        
        $requestFaculty->bind_param('s', $facultyName);
        if (!$requestFaculty->execute()) {
            throw new Exception("Ошибка выполнения запроса : " . $requestFaculty->error);
        }

        $newId = $conn->insert_id;
        if (!$newId) {
            throw new Exception("Не удалось получить ID нового факультета.");
        }
        
        $requestFaculty->close();
    }

    function bindStudent($conn) {
        $facultyId = $_POST['faculty_id'] ?? null;
        $firstName = $_POST['first_name'] ?? null;
        $yearApply = $_POST['year_apply'] ?? null;
        $mentorId = $_POST['mentor_id'] ?? null;

        if (!$facultyId || !$firstName || !$yearApply || !$mentorId) {
            throw new Exception('Данные: faculty_name, first_name, year_apply, mentor_id обязательны.', 400);
        }

        $sqlCheck = "SELECT id FROM faculty WHERE id = ?";
        $requestCheck = $conn->prepare($sqlCheck);
        if (!$requestCheck) {
            throw new Exception("Ошибка подготовки запроса : " . $conn->error);
        }

        $requestCheck->bind_param('i', $facultyId);
        if (!$requestCheck->execute()) {
            throw new Exception("Ошибка выполнения запроса : " . $requestCheck->error);
        }

        $result = $requestCheck->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("Факультет не существует.", 404);
        }
        $requestCheck->close();

        $sqlCheck = "SELECT id FROM mentor WHERE id = ?";
        $requestCheck = $conn->prepare($sqlCheck);
        if (!$requestCheck) {
            throw new Exception("Ошибка подготовки запроса : " . $conn->error);
        }

        $requestCheck->bind_param('i', $mentorId);
        if (!$requestCheck->execute()) {
            throw new Exception("Ошибка выполнения запроса : " . $requestCheck->error);
        }

        $result = $requestCheck->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("Наставника не существует.", 404);
        }
        $requestCheck->close();

        $sqlStudent = "INSERT INTO student (faculty_id, first_name, year_apply, mentor_id) VALUES (?, ?, ?, ?)";
        $requestStudent = $conn->prepare($sqlStudent);
        if (!$requestStudent) {
            throw new Exception("Ошибка подготовки запроса : " . $conn->error);
        }
        
        $requestStudent->bind_param('isii', $facultyId, $firstName, $yearApply, $mentorId);
        if (!$requestStudent->execute()) {
            throw new Exception("Ошибка выполнения запроса : " . $requestStudent->error);
        }

        $newId = $conn->insert_id;
        if (!$newId) {
            throw new Exception("Не удалось получить ID нового студента.");
        }
        
        $requestStudent->close();
    }

    function bindMentor($conn) {
        $facultyId = $_POST['faculty_id'] ?? null;
        $firstName = $_POST['first_name'] ?? null;

        if (!$facultyId || !$firstName) {
            throw new Exception('Данные: faculty_name, first_name обязательны.', 400);
        }

        $sqlCheck = "SELECT id FROM faculty WHERE id = ?";
        $requestCheck = $conn->prepare($sqlCheck);
        if (!$requestCheck) {
            throw new Exception("Ошибка подготовки запроса : " . $conn->error);
        }

        $requestCheck->bind_param('i', $facultyId);
        if (!$requestCheck->execute()) {
            throw new Exception("Ошибка выполнения запроса : " . $requestCheck->error);
        }

        $result = $requestCheck->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("Факультет не существует.", 404);
        }
        $requestCheck->close();

        $sqlMentor = "INSERT INTO mentor (faculty_id, first_name) VALUES (?, ?)";
        $requestMentor = $conn->prepare($sqlMentor);
        if (!$requestMentor) {
            throw new Exception("Ошибка подготовки запроса : " . $conn->error);
        }
        
        $requestMentor->bind_param('is', $facultyId, $firstName);
        if (!$requestMentor->execute()) {
            throw new Exception("Ошибка выполнения запроса : " . $requestMentor->error);
        }

        $newId = $conn->insert_id;
        if (!$newId) {
            throw new Exception("Не удалось получить ID нового студента.");
        }
        
        $requestMentor->close();
    }

    $from = $_POST["from"] ?? null;

    if (!$from) {
        throw new Exception('Данные: from обязательны.', 400);
    }

    switch ($from) {
        case 'faculty':
            bindFaculty($conn);
            break;
        case 'student':
            bindStudent($conn);
            break;
        case 'mentor':
            bindMentor($conn);
            break;
        default:
            throw new Exception("Неизвестные данные: " . $from);
    }

    $conn->commit();

    http_response_code(201); 
    echo json_encode([
        'status' => 'success',
        'message' => 'Запрос успешно обработан!'
    ]);

} catch (Exception $e) {
    
    $conn->rollback();

    $error_code = $e->getCode() ?: 500; 
    http_response_code($error_code);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);

} 

if (isset($conn)) {
    $conn->close();
}

?>