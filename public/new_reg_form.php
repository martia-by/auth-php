<?php

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
// Создание экземпляра Twig
$twig = new \Twig\Environment($loader);

if (!isset($_SESSION['logged_in'])) {
    echo $twig->render('newregform.twig'); 
}
