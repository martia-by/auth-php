<?php

namespace AuthPhp;

class Dbtest {

  private $db_path = DB_TEST;

  //  private $username;
  //  private $age;


    public function __construct() {
   //   if(file_exists($this->db_path)) echo '<br>База найдена ' . $this->db_path; else echo '<br>Базы нет' . DB_TEST;
    }

    public function getcontent()  {
      $file_content = file_get_contents($this->db_path);
      return $file_content;
    }

}
