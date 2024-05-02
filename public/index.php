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
        $what_am_I_doing = "submit new line in db: ";
    } else if (isset($_POST['create'])) {
        $what_am_I_doing = "create new line in db: ";
    } else if (isset($_POST['update'])) {
        $what_am_I_doing = "update new line in db: n";
    } else if (isset($_POST['find'])) {
        $what_am_I_doing = "find new line in db: ";
    } else if (isset($_POST['call'])) {
        $what_am_I_doing = "call";
    } else if (isset($_POST['null'])) {
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


