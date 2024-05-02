<?php

namespace AuthPhp;

class User {
    private $username;
    private $password;
    private $email;
    private $name;

    public function __construct() {
        //$this->username = $username;
        //$this->email = $email;
        //$this->password = $this->hashPassword($password);
        //$this->name = $name;
    }

    private function hashPassword($password) {
        // Хэширование пароля с использованием безопасного алгоритма
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function validate() {
        // Валидация свойств пользователя перед сохранением
        if (strlen($this->username) < 6) {
            throw new Exception("Username must be at least 6 characters long.");
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        if (strlen($this->password) < 6) {
            throw new Exception("Password must be at least 6 characters long.");
        }
        // Проверка на уникальность username и email
        // Здесь должен быть код для проверки в базе данных
    }

    public function save() {
        // Сохранение пользователя в базу данных
        // Здесь должен быть код для вставки данных в БД
        echo "User saved successfully!";
    }
}
