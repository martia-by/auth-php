<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\CrudJson;


$dbjson = new CrudJson("lasttest.json"); 
//$dbjson->createdb();
//$dbjson->show();


$data2array = [
  'login' => 'Tanya',
  'password' => 'mylittlesister',
  'name' => 'Таня'
];

$data1array = [
  'login' => 'Tanya',
  'password' => 'mylittlesister',
  'name' => 'Таня',
  'hashpassword' => 'lalala'
];


//var_dump($data2array);

//$dbjson->create($data1array); //create
//$readdata = $dbjson->read(); //read
//var_dump($readdata);
//$dbjson->update(8, $data1array); //update
//$dbjson->delete(1); //delete


//$dbjson->deletedb();
$dbjson->show(); //show


