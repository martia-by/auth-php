<?php

namespace AuthPhp;

use AuthPhp\DatabaseCrudJson;

class ValidatorEmail
{
    private $error;
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
            $this->error = "Введите корректный адрес электронной почты.";
            return $this->error;
        } elseif (!$this->isEmailUnique($email)) {
            $this->error = "Электронная почта уже используется.";
            return $this->error;
        }

        unset($this->error);
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
}