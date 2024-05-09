<?php

namespace AuthPhp;

require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DatabaseCrudJson;

class ValidatorName
{
    private $errors = [
        'name' => 'error'
    ];

    public function validate($name)
    {
        // Проверка длины имени
        if (mb_strlen(trim($name)) < 2) {
            $this->errors['name'] = "Имя должно содержать не менее 2 символов.";
            return $this->errors['name'];
        } 

        // Проверка чтобы были только буквы
        if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
            $this->errors['name'] = "Может содержать только буквы и пробелы";
            return $this->errors['name'];
        }

        unset($this->errors['name']);
        return null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}