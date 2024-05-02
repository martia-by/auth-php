<?php
header('Content-Type: application/json');
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DbTest;
use AuthPhp\User;

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $user = new User();
  $database = new DbTest();

  $login = $_POST['login'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $name = $_POST['name'];

  $errors = [];

  if (empty($login) || empty($email) || empty($password) || empty($confirm_password) || empty($name)) {
      $errors[] = "Все поля обязательны для заполнения.";
  }

  if ($password !== $confirm_password) {
      $errors[] = "Пароли не совпадают.";
  }



  

  if (empty($errors)) {
      // Предположим, что метод create возвращает true, если регистрация прошла успешно
      $createSuccess = $database->return_true([
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

  echo json_encode($response);


}