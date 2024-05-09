<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use AuthPhp\DatabaseCrudJson;

// Создание экземпляра загрузчика Twig с указанием пути к шаблонам
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
// Создание экземпляра Twig
$twig = new \Twig\Environment($loader);

$what_am_I_doing = '';

$db1 = new DatabaseCrudJson("users.json");

$what_am_I_doing = "";
$db_content_in_html = "";  


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['showmedb'])) {
        $what_am_I_doing = "Показыаем БД";
        $dbarray = $db1->read();
        // Запускаем буферизацию вывода
        ob_start();
        // Выводим массив с помощью print_r
        print_r($dbarray);
        // Получаем содержимое текущего буфера и одновременно очищаем его
        $content = ob_get_clean();

        $db_content_in_html = "<h2>Содержимое базы данных:</h2> <pre>" . $content . "</pre>";;
        //;
    } else echo "";
}

$variables = [
    'db_content_in_html' => $db_content_in_html,
    'what_am_I_doing' => $what_am_I_doing
];

// Рендеринг шаблона
echo $twig->render('old_regform.twig', $variables); // Передача переменных в шаблон


