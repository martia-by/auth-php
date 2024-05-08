<?php
$pages = [
    'main' => 'Главная',
    'regform' => 'Регистрационная форма',
    'autorization' => 'Страница авторизации',
    'crudjson' => 'Тесторая для работы с базой',
    'new_reg_form' => 'Новая форма регистрации'
    
];

// Предварительно загружаем данные урока, если указан
$title = "Точка входа";  // Значение по умолчанию для заголовка
$pageContent = '';  // Переменная для хранения содержимого урока

if (isset($_GET['page'])) {
    $pageFile = $_GET['page'] . '.php';
    if (file_exists($pageFile)) {
        ob_start();  // Включение буферизации вывода
        include($pageFile);
        $title = $pages[$_GET['page']];
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
  <script src="js/reg_script.js" defer></script>
</head>
<body>
  <header>
    <nav>
<?php
// Автоматическое создание ссылок на страницы
foreach ($pages as $key => $pageDescription) {
    echo "<a href=\"index.php?page=$key\">$pageDescription</a><br>" . PHP_EOL;
}
?>
    </nav>
  </header>
  <section id="pageContent">
  <?php echo $pageContent; // Вывод содержимого урока ?>
  </section>

  
</body>
</html>