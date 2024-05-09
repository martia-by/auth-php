<?php

namespace AuthPhp;

/**
 * Класс для управления данными пользователя в JSON-формате.
 * Поддерживает операции CRUD для работы с пользователями.
 */
class OldDatabase {
    private $db_path = DB_USER_PATH; 
    private $users = [];

    /**
     * Сразу читаем весь массив и будем с ним работать
     */
    public function __construct() {
        $this->loadUsers();
    }

    /**
     * Загружает пользователей из файла JSON.
     */
    private function loadUsers() {
        if (!file_exists($this->db_path)) {
            throw new \Exception("Файл базы данных не найден: {$this->db_path}");
        }
        $content = file_get_contents($this->db_path);
        $this->users = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Ошибка чтения JSON: " . json_last_error_msg());
        }
    }

    /**
     * Проверяет уникальность логина.
     */
    public function isLoginUnique($login) {
        foreach ($this->users as $user) {
            if ($user['login'] === $login) {
                return false;
            }
        }
        return true;
    }


    /**
     * Проверяет уникальность email.
     */
    public function isEmailUnique($email) {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return false;
            }
        }
        return true;
    }

    /**
     *  CRUD
     */

    /**
     * CREATE
     * Добавляет нового пользователя в базу данных.
     *
     * @param array $data массив данных пользователя.
     * @return true в случае успешного добавления, иначе выбрасывает исключение.
     * @return \Exception если пользователь с таким логином или email уже существует или произошла ошибка записи.
     */
    public function create($data) {
        // Проверка уникальности логина и email
        if (!$this->isLoginUnique($data['login']) || !$this->isEmailUnique($data['email'])) {
            throw new \Exception("Пользователь с таким логином или email уже существует.");
        }
        // Добавление пользователя в массив
        $this->users[] = $data;
        // Запись данных в файл
        $result = file_put_contents($this->db_path, json_encode($this->users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        // Проверка успешности записи в файл
        if ($result === false) {
            throw new \Exception("Ошибка при записи данных в файл.");
        }
        return true; 
    }

    /**
     * Возвращает данные пользователя по логину.
     * @param string $login Логин пользователя.
     */
    public function readlogin($login) {
        foreach ($this->users as $user) {
            if ($user['login'] === $login) {
                return $user;
            }
        }
        return null; // Пользователь не найден
    }

    /**
     * Возвращает данные пользователя по заданному ключу и значению.
     * @param string $key Ключ поиска в данных пользователя (например, 'login', 'email', 'name').
     * @param string $value Значение для поиска по указанному ключу.
     * @return array|null Возвращает массив с данными пользователя или null, если пользователь не найден.
     */
    public function read($key, $value) {
        foreach ($this->users as $user) {
            if (isset($user[$key]) && $user[$key] === $value) {
                return $user;
            }
        }
        return null; // Пользователь не найден
    }

    /**
     * Обновляет данные пользователя.
     * @param string $login Логин пользователя для поиска.
     * @param array $newData Новые данные для обновления.
     * @return bool Возвращает true при успешном обновлении данных.
     * @throws \Exception Если пользователь не найден или произошла ошибка при записи.
     */
    public function update($login, $newData) {
        $found = false;
        foreach ($this->users as $key => $user) {
            if ($user['login'] === $login) {
                $this->users[$key] = array_merge($user, $newData);
                $found = true;
                break;
            }
        }
        if (!$found) {
            throw new \Exception("Пользователь с логином {$login} не найден.");
        }
        $result = file_put_contents($this->db_path, json_encode($this->users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        if ($result === false) {
            throw new \Exception("Ошибка при записи данных в файл.");
        }
        return true;
    }


    /**
     * Для теста получаем содержимое БД
     */
    public function getcontent() {
        return file_get_contents($this->db_path);
    }

}