<?php

namespace AuthPhp;

class OldValidator {
    /**
     * Валидация логина (длина 6+ символов и пробелы)
     */
    public static function validateLogin($login) {
    // Проверка длины логина
    if (strlen($login) < 6) {
        return "Логин должен быть не менее 6 символов.";
    }
    // Проверка на наличие пробелов в логине
    if (strpos($login, ' ') !== false) {
        return "Логин не должен содержать пробелов.";
    }
    return ""; // Если все проверки пройдены успешно
    }


    /**
     * Валидация пароля. Цифры + буквы. Не менее + символов.
     */
    public static function validatePassword($password) {
        if (strlen($password) < 6 || !preg_match('/[a-zA-Z]/', $password) || !preg_match('/\d/', $password)) {
            return "Пароль должен быть не менее 6 символов и содержать хотя бы одну букву и одну цифру.";
        }
        return "";
    }

    /**
     * Валидация электронной почты
     */
    public static function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Некорректный формат email.";
        }
        return "";
    }

    /**
     * Валидация имени. 2 буквы, без пробелов.
     */
    public static function validateName($name) {
        if (strlen($name) < 2 || !preg_match('/^[a-zA-Zа-яА-ЯёЁ]+$/', $name)) {
            return "Имя должно состоять минимум из 2 букв.";
        }
        if (strpos($name, ' ') !== false) {
            return "Имя не должно содержать пробелов.";
        }
        return "";
    }
}
