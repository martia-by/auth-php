<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\Database;
use AuthPhp\User;
use AuthPhp\CrudJson;


echo "Hello world!";

$dbjson = new CrudJson("1.json");
//$dbjson->create();
//$dbjson->show();


$data2array = [
  'login' => 'id3',
  'password' => '2test',
  'name' => '1test'
];

//var_dump($data2array);

//$dbjson->c($data2array);
//$dbjson->d(2);
//$dbjson->show();
//$readdata = $dbjson->r();
echo "<pre>" . print_r($dbjson->r(), true);



//$file=__DIR__ . '/../db/test.json';
//file_put_contents($file, json_encode([]));
