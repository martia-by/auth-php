document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('register');
  form.addEventListener('submit', function (event) {
    event.preventDefault();  // Предотвращаем стандартную отправку формы

    const formData = new FormData(form); // Собираем данные формы

    fetch('register.php', { // Путь к серверному скрипту, который будет обрабатывать данные
      method: 'POST',
      body: formData
    })
      .then(response => response.json()) // Предполагаем, что сервер возвращает JSON
      .then(data => {
        console.log(data); // Обработка данных, полученных от сервера
        if (data.success) {

          $(document).ready(function () {
            $("#register input").css("background-color", "rgb(231, 255, 234)");
            $("#register label").css("color", "rgb(9, 159, 28)");
            // Устанавливаем начальные стили для плавного изменения
            $(".form-group").css({
              "transition": "opacity 0.5s ease",
              "opacity": "1"  // Начальная прозрачность
            });

            // Применяем плавное исчезновение к каждой группе
            $(".form-group").each(function (index) {
              var item = $(this);
              setTimeout(function () {
                item.css("opacity", "0"); // Плавное исчезновение
                setTimeout(function () {
                  item.css("display", "none"); // Скрыть после анимации
                }, 500);
              }, 1500 + 90 * index);
            });

            // Последний тайм-аут для кнопки и сообщения
            var totalGroups = $(".form-group").length;
            setTimeout(function () {
              $("button[type='submit']").css("opacity", "0"); // Скрыть кнопку
              setTimeout(function () {
                $("button[type='submit']").css("display", "none"); // Убрать кнопку из DOM
                $("#result-message").css({
                  "display": "block",
                  "opacity": "0",
                  "transition": "opacity 0.5s ease"
                });
                $("#result-message").css({ "opacity": "1", "display": "block", "color": "rgb(9, 159, 28)"});
                $("#reg-form").css({"color": "rgb(9, 159, 28)" }); // Показать сообщение
                document.getElementById('reg-form').innerHTML = 'Регистрация прошла успешно!';
              }, 500);
            }, 1500 + 90 * totalGroups);
          });

        } else {
          $("#result-message").css({ "opacity": "1", "display": "block" });
          document.getElementById('result-message').innerHTML = '<p style=\'transition: all 1s ease-out;\'>' + data.message + '</p>';
        }
      })
      .catch(error => {
        $("#result-message").css("display", "block");
        $("#reg-form").css("color", "rgb(9, 159, 28)"); // Показать сообщение
        document.getElementById('result-message').innerHTML = '<p>' + data.message + '</p>';
        console.error('Ошибка AJAX запроса: ', error);
      });
  });
});