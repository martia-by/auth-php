<?php

namespace AuthPhp;

class OldUser {
    private $username;
    private $password;
    private $email;
    private $name;

    //public function __construct() {
    //}


    /**
     * Хэширование пароля пользователя. 
     * Говорят, что password_hash() / password_verify() надёжнее и безопаснее, чем соль+md5 или соль+sha1
     * +Меньшепеременных, меньше записей в БД
     * 
     * Но если надо, то
     * $salt = random_bytes(16); //Но мы не сможем записать его в JSON БД. Вариант 
     * $salt = base64_encode(random_bytes(16));
     * $saltedPassword = $salt . md5($password);
     * $hash = hash("sha256", $saltedPassword); или $hash = md5($salt . $password); 
     * +Для хранения в базе данных добавляем каждому пользователю поле $salt
     */
    private function hashPassword($password) {
        // Хэширование пароля с использованием безопасного алгоритма
        return password_hash($password, PASSWORD_DEFAULT);
    }

}
