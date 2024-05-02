<?php

namespace AuthPhp;

/**
 * сама база лежит в /db/db-test.json
 * используем тестовую (config.php) DB_TEST
 *  * 
 * CRUD крнцепт
 * 
 * create $this->create
 * read
 * update
 * delete
 * 
 * 
 * 
 * 
 * Что у нас вообще должно быть? 
 * 1. подключение к базе.
 * 2. ф-я проверки передаваемых данных :
 *    2.1 
 * 3. CRUD
 * 
 * 
 * Начнем с простого добавления записи в текстфайл
 */

class Dbtest {

  private $db_path = DB_TEST; 
  public $data="";

  //  private $username;
  //  private $age;


    public function __construct() {
   //   if(file_exists($this->db_path)) echo '<br>База найдена ' . $this->db_path; else echo '<br>Базы нет' . DB_TEST;
    }

    public function getcontent() {
      $file_content = file_get_contents($this->db_path);
      return $file_content;
    }

    public function create($data) {
      //проверяем, передали что-то или нет
      if (isset($data)) {
            // Преобразовываем данные в строку
              $record = $data;

              // Открываем файл базы данных для добавления новой записи
              $file = fopen($this->db_path, 'a');

              // Добавляем новую запись в файл с новой строки
              fwrite($file, $record . PHP_EOL);

              // Закрываем файл
              fclose($file);
      } else {
        print("Данные не переданы");
      }
    }

    function return_true(){
      return(true);
    }



}
