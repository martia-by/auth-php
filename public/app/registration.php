<?php

require __DIR__ . '/../../vendor/autoload.php';

use AuthPhp\ValidatorLogin;
use AuthPhp\ValidatorPassword;
use AuthPhp\ValidatorEmail;
use AuthPhp\ValidatorName;
use AuthPhp\DatabaseCrudJson;

// Проверяем, установлен ли заголовок X-Requested-With и равен ли он 'XMLHttpRequest'
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    // Если это не AJAX-запрос, прекращаем выполнение скрипта
    die('Access denied: only AJAX requests are allowed');
}
// Проверка метода запроса и наличия POST данных
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    header("Location: /");
    exit;
}

// Создаем валидаторы
$loginValidator = new ValidatorLogin();
$passwordValidator = new ValidatorPassword();
$emailValidator = new ValidatorEmail();
$nameValidator = new ValidatorName();

// Сбор ошибок
$errors = [
    'login' => isset($_POST['login']) ? $loginValidator->validate($_POST['login']) : '',
    'password' => isset($_POST['password']) ? $passwordValidator->validate($_POST['password']) : '',
    'password_confirm' => isset($_POST['password_confirm']) ? $passwordValidator->validate($_POST['password_confirm']) : '',
    'email' => isset($_POST['email']) ? $emailValidator->validate($_POST['email']) : '',
    'name' => isset($_POST['name']) ? $nameValidator->validate($_POST['name']) : ''
];

// Проверка на совпадение паролей
if ($_POST['password'] !== $_POST['password_confirm']) {
    $errors['password_confirm'] = 'Пароли не совпадают'; 
}

// Создаем запись
if (isset($_POST['submit']) && !array_filter($errors)) {
    $database = new DatabaseCrudJson("users.json");
    $createSuccess = $database->create([
        'login' => trim($_POST['login']),
        'email' => trim($_POST['email']),
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'name' => preg_replace('/\s+/', ' ', trim($_POST['name'])) //обрезаем пробелы по бокам + заменяем повторяющиеся пробелы (preg_replace('/\s+/', ' ', $string)
    ]);

    // Проверяем успешность создания записи
    if ($createSuccess) {
        $errors['created'] = true;
    } else {
        $errors['created'] = false;
    }
} 

echo json_encode($errors, JSON_UNESCAPED_UNICODE);