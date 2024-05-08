<?php

namespace AuthPhp;

/**
 * Класс будет работать с любым БД файлом JSON, который был создан этим классом. Есть своим особенности.
 * 
 * У каждого элемента массива JSON с момента создания есть свой id;
 * id генерируется автоматически (последний +1)
 * 
 *Основные функции CRUD:
 * 
 * create() создание записи добавляем newid + $data 
 * read() чтение всего массива json. Или чтение элемента с нужным id
 * update() обновление элемента с нужным id на $data
 * delete() удаление элемента с заданным id
 * 
 * Доп функции
 * createdb($path) создание файла json
 * deletedb($path) удаление файла json
 * 
 * loadData() Чтение json
 * saveData() запись (обновление) json
 * 
 * show() показать содержимое json
 * newId() ищем последний ID, если нет такого, делаем id = 1;
 */

class DatabaseCrudJson 
{
    private $filePath;

    /**
     * Инициализируем путь к JSON.
     * При создании нового элемента проверяем существование массива, если нет такого - создаем.
     */
    public function __construct($path) 
    {
      $this->filePath = __DIR__ . "/../db/" . $path;
      if (!file_exists($this->filePath)) {
          echo "База не найдена<br>Создадим новую... $path";
          $this->createdb();
      }
    }

    /**
     * создание записи.
     * читаем массив, добавляем новую запись, присваиваем каждой новой записи новый ID
     */
    public function create($data) 
    {
        $allData = $this->loadData();
        $newId = $this->newid();
        $newIdArray = ['id'=>$newId];
        $allData[] = array_merge($newIdArray, $data);
        $this->saveData($allData);
    }

    /**
     * читаем базу, возвращаем запись с указанным ID
     * Если не eуказано условие - возвращаем весь массив
     */
    public function read($id = null)
    {
        $allData = $this->loadData();
        if($id === null) {
            return $allData;
        } else {
            foreach ($allData as $index => $entry)
            {
                if(($entry['id'] === $id)) {
                    return $entry;
                }
            } 
        }
    }


    /**
     * Изменяем данные с заданным ID на новые.
     * В случае обновления - возвращаем true
     * В случае неудачи - возвращаем false
     */
    public function update($id, $Data) 
    {
        $allData = $this->loadData();
        $found = false; 
        foreach ($allData as $index => $entry)
        {
          if(($entry['id'] === $id)) {
              $newArray = array_merge(['id'=>$id], $Data);
              $allData[$index] = $newArray;
              $this->saveData($allData);
              $found = true;
              break;
          }
        } 
        return $found;
    }

    public function delete($id = null)
    {
        if ($id === null) return false; //Не указан id - ничего не делаем
        $allData = $this->loadData();
        foreach ($allData as $index => $entry) 
        {
            if ($entry['id'] === $id) {
                array_splice($allData, $index, 1);
                $this->saveData($allData);
                return true;
            } 
        }
        return false; // если запись с указанным ID не найдена
    }

    /**
     * Создаем базу с именем указанным при инициализации класса
     * инициализируется при инициализации класса, поэтому private
     */
    private function createdb()
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
            return true;
        } 
        return false; 
    }

    /**
     * удаляем базу 
     */
    public function deletedb()
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
            return true;
        }
        return false;
    }

    /**
     * читаем весь массив (БД)
     */
    private function loadData() 
    {
        return json_decode(file_get_contents($this->filePath), true);
    }

    /**
     * Сохраняем массив (БД)
     */
    private function saveData($data) {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Получаем новый ID. Возвращаем последний ID +1 
     * Если нет элементов, тогда возвращаем 1
     */
    private function newid()
    {
        $array = $this->loadData();
        $array_count = count($array);
        if ($array_count>0) {
            $last_db_element = $array[$array_count-1];
            $lastId = $last_db_element['id']+1;
            return $lastId; //возвращаем значение последнего ID
        } else {
            return 1; //возвращаем 1 если нет элементов массива
        }
    }

    /**
     * Функция для вывода содержимого массива
     * типа read без id, только сразу структурирована и с выводом
     */
    public function show()
    {
        echo '<pre>' . print_r($this->loadData(), true) . '</pre>';
    }
}