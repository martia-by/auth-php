<?php

namespace AuthPhp;

use AuthPhp\DatabaseCrudJson;

class ValidatorLogin
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

    public function validate($login)
    {
        // Проверка длины логина
        if (mb_strlen($login) < 6) {
            $this->error = "Логин должен быть не менее 6 символов.";
            return $this->error;
        } 
        
        // Проверка наличия пробелов в логине
        if (strpos($login, ' ') !== false) {
            $this->error = "Логин не должен содержать пробелы.";
            return $this->error;
        }
        
        // Проверка уникальности логина
        if (!$this->isLoginUnique($login)) {
            $this->error = "Логин занят.";
            return $this->error;
        }

        unset($this->error);
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
}
