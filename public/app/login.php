<?php

session_start();

require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../vendor/autoload.php';

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

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $databasenew = new DatabaseCrudJson(DB_NAME); 

    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $errors = [];
    $foundedUser = false;
    $searching_usr_pass_hash ='';

    // Проверка логина
    $db_data = $databasenew->read();

    foreach($db_data as $element) {
        if ($element['login'] === $login) {
            $searching_usr_passhash = $element['password'];
            $searching_usr_name = $element['name'];
            $foundedUser = true;
            //var_dump($element);
            break;
        }         
    }            
    
    if (!$foundedUser) {
        $errors['errorLogin'] = 'Пользователь не найден';
        //var_dump($foundedUser);
    } 

    if ($foundedUser && !password_verify($password,$searching_usr_passhash)) {
        $errors['errorPassword'] = 'Пароль не верный';
    }

    if ($foundedUser && password_verify($password,$searching_usr_passhash)) {
        $_SESSION['currentuser'] = $login;
        $_SESSION['currentusername'] = $searching_usr_name;
        $_SESSION['logged_in'] = true;
    }


    if (empty($errors)) {
        // Если нет ошибок авторизуем пользователя
            $response = ['success' => true, 'message' => 'Авторизация прошла успешно!'];
            $response['username']=$searching_usr_name;
        } else {
            $response = $errors;
            //var_dump($errors);
        }



    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}