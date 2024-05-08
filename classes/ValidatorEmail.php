<?php

namespace AuthPhp;

require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DatabaseCrudJson;

class ValidatorEmail
{
    private $errors = [
        'email' => 'error',
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

    public function validate($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Введите корректный адрес электронной почты.";
            return $this->errors['email'];
        } elseif (!$this->isEmailUnique($email)) {
            $this->errors['email'] = "Электронная почта уже используется.";
            return $this->errors['email'];
        }

        unset($this->errors['email']);
        return null;
    }

    private function isEmailUnique($email)
    {
        foreach ($this->usersArray as $user) {
            if ($user['email'] === $email) {
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