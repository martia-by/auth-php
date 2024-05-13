<?php
// Создание экземпляра загрузчика Twig с указанием пути к шаблонам
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
// Создание экземпляра Twig
$twig = new \Twig\Environment($loader);


if (!isset($_SESSION['logged_in'])) {
    echo $twig->render('login.twig');     
} else {
    echo "Как дела, " . $_SESSION['currentusername'] . "?";
}


