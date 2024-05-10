<?php

namespace AuthPhp;

class ValidatorPassword
{
    private $error;

    public function validate($password)
    {
        // Проверка на длину пароля
        if (strlen($password) < 6) {
            $this->error = "Пароль должен содержать не менее 6 символов.";
            return $this->error;
        }

        // Проверка на наличие букв и цифр в пароле
        if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/\d/', $password)) {
            $this->error = "Пароль должен содержать буквы и цифры.";
            return $this->error;
        }

        unset($this->error);
        return null;
    }
}