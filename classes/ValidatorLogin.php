<?php

namespace AuthPhp;

require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DatabaseCrudJson;

class ValidatorLogin
{
    private $errors = [
        'login' => 'error',
        'password' => 'error',
        'email' => 'error',
        'name' => 'error'
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

    public function validateLogin($login)
    {
        // Проверка длины логина
        if (mb_strlen($login) < 6) {
            $this->errors['login'] = "Логин должен быть не менее 6 символов.";
            return $this->errors['login'];
        } 
        
        // Проверка наличия пробелов в логине
        if (strpos($login, ' ') !== false) {
            $this->errors['login'] = "Логин не должен содержать пробелы.";
            return $this->errors['login'];
        }
        
        // Проверка уникальности логина
        if (!$this->isLoginUnique($login)) {
            $this->errors['login'] = "Логин занят.";
            return $this->errors['login'];
        }

        unset($this->errors['login']);
        return null;
    }

    private function isLoginUnique($login)
    {
        foreach ($this->usersArray as $user) {
            if ($user['login'] === $login) {
                return false;
            }
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
