<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DatabaseCrudJson;

$dbjson = new DatabaseCrudJson("users.json"); 
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

//setcookie("data1array", $data1array['login'], time()+5000);
//unset($_COOKIE['data1array']);



var_dump(time());

echo "<br><br><br><br> <pre>";
print_r($_COOKIE);
echo "</pre>";


//$dbjson->create($data1array); //create
//$readdata = $dbjson->read(); //read
//var_dump($readdata);
//$dbjson->update(8, $data1array); //update
//$dbjson->delete(1); //delete

//$dbjson->deletedb();

$dbjson->show(); //show


