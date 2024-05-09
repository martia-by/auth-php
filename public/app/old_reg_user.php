<?php
header('Content-Type: application/json');
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../vendor/autoload.php';

use AuthPhp\OldDatabase;
use AuthPhp\DatabaseCrudJson;
use AuthPhp\OldUser;
use AuthPhp\OldValidator;

// Проверка метода запроса и наличия POST данных
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    header("Location: /");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new OldUser();
    $database = new OldDatabase();
    $databasenew = new DatabaseCrudJson("users.json"); //только для записи новых элементов ()

    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $name = trim($_POST['name']);

    $errors = [];

    // Проверка полей
    if ($error = OldValidator::validateLogin($login)) {
    $errors['loginError'] = $error;
    }
    if ($error = OldValidator::validatePassword($password)) {
    $errors['passwordError'] = $error;
    }
    if ($error = OldValidator::validateEmail($email)) {
        $errors['emailError'] = $error;
    }
    if ($error = OldValidator::validateName($name)) {
        $errors['nameError'] = $error;
    }

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        $errors['confirm_passwordError'] = "Пароли не совпадают.";
    }

    // Проверка уникальности логина и email
    if (!$database->isLoginUnique($login)) {
        $errors['login_uniqueError'] = "Пользователь с таким логином уже существует.";
    }
    if (!$database->isEmailUnique($email)) {
        $errors['email_uniqueError'] = "Пользователь с таким email уже существует.";
    }


    if (empty($errors)) {
        // Если нет ошибок запишем пользователя в базу

        $createSuccess = $databasenew->create([
            'login' => $login,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name' => $name
        ]);

        if ($createSuccess) {
            $response = ['success' => true, 'message' => 'Регистрация прошла успешно!'];
        } else {
            $response = ['success' => false, 'errors' => ['Не удалось зарегистрировать пользователя.']];
        }
    } else {
        $response = ['success' => false, 'errors' => $errors];
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);


}