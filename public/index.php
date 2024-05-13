<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

session_start();

$pages = [
    'main' => 'Главная',
    'git' => 'Git',
    'crudjson' => 'Тесторая страница для работы с базой'
];

if (basename($_SERVER['PHP_SELF']) == 'logout.php') {
    setcookie('currentuser', '', time() - 3600, '/');  // Удаление куки 
}

// Предварительно загружаем данные урока, если указан
$title = "Регистраци / авторизация";  // Значение по умолчанию для заголовка
$pageContent = '';  // Переменная для хранения содержимого урока

if (isset($_GET['page'])) {
    $pageFile = $_GET['page'] . '.php';
    if (file_exists($pageFile)) {
        ob_start();  // Включение буферизации вывода
        include($pageFile);
        if (isset($pages[$_GET['page']])) {
            $title = $pages[$_GET['page']];
        }
        
        $pageContent = ob_get_clean();  // Получение и очистка буфера вывода
    } else {
        http_response_code(404);
        $pageContent = "<br><br>Еще не сделана страница. Получается 404 ошибка :)";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>
<body>
  <header>
    <nav>
<?php
// Автоматическое создание ссылок на страницы
/**
 * Сперва строчка приветствия / авторизации / регистрации / Выхода
 * 
 */

if (isset($_SESSION['logged_in']) && (isset($_GET['page']) && $_GET['page'] != 'logout')) {
    echo "Привет, " . $_SESSION['currentusername'] . "! ";
    echo "<a href=\"index.php?page=logout\"><button>Выход</button></a><br><hr><br>" . PHP_EOL;
} else {
    echo "<a href=\"index.php?page=login\">Войти</a> | <a href=\"index.php?page=old_regform\">Регистрация 1</a> | <a href=\"index.php?page=new_reg_form\">Регистрация 2 (нов)</a><br><hr><br>" . PHP_EOL;
}



foreach ($pages as $key => $pageDescription) {
    echo "<a href=\"index.php?page=$key\">$pageDescription</a><br>" . PHP_EOL;
}
?>
    </nav>
  </header>
  <section id="pageContent">
  <?php echo $pageContent; // Вывод содержимого ?>
  </section>

  
</body>
</html>