<?php

namespace AuthPhp;

/**
 * Класс будет работать с любым БД файлом JSON, 
 * который был создан этим классом.
 * Есть своим особенности.
 * 
 * У каждого элемента массива JSON с момента создания есть свой id;
 * id генерируется автоматически (последний +1)
 * 
 * основные функции работают 
 * 
 * Основные функции CRUD
 * create() создание записи
 * read() чтение
 * update() обновление
 * delete() удаление
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

class CrudJson 
{
  private $filePath;

  public function __construct($path) 
  {
    $this->filePath = __DIR__ . "/../db/" . $path;
    if (!file_exists($this->filePath)) 
    {
      echo "База не найдена<br>Создадим новую... $path";
      $this->createdb();
    }
  }

  /**
   * создание записи
   */
  public function create($data) 
  {
    $allData = $this->loadData();
    $newId = $this->newid();
    $newIdArray = ['id'=>$newId];
    $allData[] = array_merge($newIdArray, $data);
    //$newData = ['id' => $newId, 'data' => $data];
    //$allData[] = $newData; 
    $this->saveData($allData);
  }

  /**
   * читаем базу, возвращаем запись, если указан ID массива (не ID параметр, ID указатель записи) 
   */
  public function read($conditions = null)
  {
    $allData = $this->loadData();
    if (is_null($conditions)) {
      return $allData;
    }

    // Возвращаем записи, соответствующие критериям
    return array_filter($allData, function ($entry) use ($conditions) {
      foreach ($conditions as $key => $value) {
        if (!isset($entry[$key]) || $entry[$key] !== $value) {
          return false;
        }
      }
      return true;
    });
  }

  public function update($id, $newData) 
  {
    // Логика обновления данных
  }

  public function delete($id)
  {
    $allData = $this->loadData();
    foreach ($allData as $index => $entry) {
      if (isset($entry['id']) && $entry['id'] === $id) {
        array_splice($allData, $index, 1);
        $this->saveData($allData);
        return true;
      }
    }
    return false; // Если запись с указанным ID не найдена
  }

  /**
   * 
   */
  public function createdb()
  {
    if (!file_exists($this->filePath)) 
    {
    file_put_contents($this->filePath, json_encode([]));
    return true;
    } 
    return false; 
  }

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
   * Получаем новый ID (последний ID +1)
   */
  private function newid()
  {
    $array_count = count($this->loadData());
    if ($array_count>0) 
    {
      $last_db_element = $this->loadData()[$array_count-1];
    } else return('1');
    $lastId = $last_db_element['id']+1;
    return $lastId;
  }

  /**
   * Функция для вывода содержимого массива
   */
  public function show()
  {
    echo '<pre>' . print_r($this->loadData(), true) . '</pre>';
  }

}