<?php
$host = 'localhost';
$db_name = 'blog';
$username = 'root'; // Стандартный пользователь в Laragon
$password = '';     // У Laragon по умолчанию пустой пароль

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>