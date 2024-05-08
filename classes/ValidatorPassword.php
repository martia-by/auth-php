<?php

namespace AuthPhp;

require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DatabaseCrudJson;

class ValidatorPassword
{
    private $errors = [
        'password' => 'error',
    ];

    private $usersArray;

    public function __construct()
    {
        $this->loadUsers();
    }

    private function loadUsers()
    {
        $db = new DatabaseCrudJson("users.json");
        $this->usersArray = $db->read();
    }

    public function validate($password)
    {
        // Проверка на длину пароля
        if (strlen($password) < 6) {
            $this->errors['password'] = "Пароль должен содержать не менее 6 символов.";
            return $this->errors['password'];
        }

        // Проверка на наличие букв и цифр в пароле
        if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/\d/', $password)) {
            $this->errors['password'] = "Пароль должен содержать буквы и цифры.";
            return $this->errors['password'];
        }

        unset($this->errors['password']);
        return null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

?>
