<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\Database;
use AuthPhp\DbTest;
use AuthPhp\User;
use AuthPhp\ErrorsHandler;

// Создание экземпляра загрузчика Twig с указанием пути к шаблонам
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
// Создание экземпляра Twig
$twig = new \Twig\Environment($loader);


$what_am_I_doing = '';




//$db->create($newUser);

$db1 = new DbTest;
//echo "<br><br><pre>";

 //var_dump($db1);

//echo '</pre><br><br>';

$what_am_I_doing = "";
$db_content_in_html = "";  


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        //$db->create("Новый элемент");
        //$db->saveData();
        $send_data = [
            "login"=>$_POST['login'],
            "email"=>$_POST['email'], 
            "password"=>$_POST['password'], 
            "confirm_password"=>$_POST['confirm_password'],
            "name"=>$_POST['name'],
        ];
        $db1->create($send_data);
        echo "<pre>";
        var_dump($send_data);
        echo "</pre>";

    } else if (isset($_POST['create'])) {

        $db1->create($data2db1);
    } else if (isset($_POST['update'])) {

    } else if (isset($_POST['find'])) {

    } else if (isset($_POST['call'])) {

    } else if (isset($_POST['showmedb'])) {
        $what_am_I_doing = "Показыаем БД";
        $db_content_in_html = "<H2>Содержимое базы данных:</H2>" . $db1->getcontent();  
    } else echo "";
}

$variables = [
    'db_content_in_html' => $db_content_in_html,
    'what_am_I_doing' => $what_am_I_doing
];

// Рендеринг шаблона
echo $twig->render('index.twig', $variables); // Передача переменных в шаблон


