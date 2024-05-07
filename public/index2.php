<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\Database;
use AuthPhp\User;
use AuthPhp\CrudJson;


//echo "Hello world!";

$dbjson = new CrudJson("test985.json");
//$dbjson->createdb();
//$dbjson->show();


$data2array = [
  'login' => 'Martia',
  'password' => 'whynot?',
  'name' => 'Alex'
];

//var_dump($data2array);

//$dbjson->create($data2array);
//$dbjson->delete(2);
//$dbjson->show();
$readdata = $dbjson->read();
echo "<pre>" . print_r($readdata, true);
//echo $dbjson->newId();

//var_dump($readdata[0]);



//$file=__DIR__ . '/../db/test.json';
//file_put_contents($file, json_encode([]));
