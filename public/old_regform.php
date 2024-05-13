<?php

use AuthPhp\DatabaseCrudJson;

// Создание экземпляра загрузчика Twig с указанием пути к шаблонам
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
// Создание экземпляра Twig
$twig = new \Twig\Environment($loader);

$db1 = new DatabaseCrudJson("users.json");

$db_content_in_html ='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['showmedb'])) {
        $dbarray = $db1->read();
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
    'db_content_in_html' => $db_content_in_html
];

// Рендеринг шаблона
if (!isset($_SESSION['logged_in'])) {
    echo $twig->render('old_regform.twig', $variables); // Передача переменных в шаблон
}


