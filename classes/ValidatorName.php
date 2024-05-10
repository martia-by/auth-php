<?php

namespace AuthPhp;

class ValidatorName
{
    private $error;

    public function validate($name)
    {
        // Проверка длины имени
        if (mb_strlen(trim($name)) < 2) {
            $this->error = "Имя должно содержать не менее 2 символов.";
            return $this->error;
        } 

        // Проверка чтобы были только буквы
        if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
            $this->error = "Может содержать только буквы и пробелы";
            return $this->error;
        }

        unset($this->error);
        return null;
    }
}