<?php

namespace AuthPhp;

/**
 * Класс будет работать с любым БД файлом JSON
 * Основные функции
 * c() создание записи
 * r() чтение
 * u() обновление
 * d() удаление
 * 
 * Доп функции
 * create($path) создание файла json
 * delete($path) удалени файла json
 * 
 * loadData() Чтение json
 * saveData() запись (обновление) json
 * 
 * show() показать содержимое json
 * 
 */

class CrudJson 
{
  private $filePath;

  public  function __construct($path) 
  {
    $this->filePath = __DIR__ . "/../db/" . $path;
  }

  public function c($data) 
  {
    $allData = $this->loadData();
    $allData[] = $data; 
    $this->saveData($allData);
  }

  public function r($criteria = null)
  {
    $allData = $this->loadData();
    if (is_null($criteria)) {
      return $allData;
    }

    // Возвращаем записи, соответствующие критериям
    return array_filter($allData, function ($entry) use ($criteria) {
      foreach ($criteria as $key => $value) {
        if (!isset($entry[$key]) || $entry[$key] !== $value) {
          return false;
        }
      }
      return true;
    });
  }

  public function u($id, $newData) 
  {
    // Логика обновления данных
  }

  public function d($id)
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
  public function create()
  {
    if (!file_exists($this->filePath)) 
    {
    file_put_contents($this->filePath, json_encode([]));
    return true;
    } 
    return false; 
  }

  public function delete()
  {
    if (file_exists($this->filePath)) {
      unlink($this->filePath);
      return true;
    }
    return false;
  }

  private function loadData() 
  {
    return json_decode(file_get_contents($this->filePath), true);
  }

  private function saveData($data) {
    file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
  }

  /**
   * Функция для вывода содержимого массива
   */
  public function show()
  {
    echo '<pre>' . print_r($this->loadData(), true) . '</pre>';
  }

}