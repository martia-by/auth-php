document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('register');
  form.addEventListener('submit', function (event) {
    event.preventDefault();  // Предотвращаем стандартную отправку формы
    const formData = new FormData(form); // Собираем данные формы

    fetch('reg_user.php', { // Путь к серверному скрипту, который будет обрабатывать данные
      method: 'POST',
      body: formData
    })
    
      .then(response => response.json()) 
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
                $("#result-message").css({ "opacity": "1", "display": "block", "color": "rgb(9, 159, 28)" });
                $("#reg-form").css({ "color": "rgb(9, 159, 28)" }); // Показать сообщение
                document.getElementById('reg-form').innerHTML = 'Регистрация прошла успешно!';
              }, 500);
            }, 1500 + 90 * totalGroups);
          });

        } else {
          // Обработка ошибок

          let hasFieldErrors = true;
          longError = "";
          Object.keys(data.errors).forEach(key => {
            const errorElement = document.getElementById(key + 'Error');


              if (key === 'loginError') 
              {
                //console.log("loginError");
                $("#login_info").css("color", "red");
                $("#login").css("background-color", "#ffebeb");
                longError = longError + data.errors[key] + " ";
              } 
              else if (key === 'login_uniqueError') 
              {
                //console.log("login_uniqueError");
                $("#login_info").css("color", "red");
                $("#login").css("background-color", "#ffebeb");
                document.getElementById("login_info").innerHTML = data.errors[key];
                longError = longError + data.errors[key] + " ";
              }
              else if (key === 'emailError') 
              {
                //console.log("emailError");
                $("#email_info").css("color", "red");
                document.getElementById("email_info").innerHTML = "* Введите корректный адрес email.";
                $("#email").css("background-color", "#ffebeb");
                longError = longError + data.errors[key] + " ";
              } 
              else if (key === 'passwordError') 
              {
                //console.log("passwordError");
                $("#pass_info").css("color", "red");
                $("#password").css("background-color", "#ffebeb");
                $("#confirm_password").css("background-color", "#ffebeb");
                longError = longError + data.errors[key] + " ";
              } 
              else if (key === 'confirm_passwordError') 
              {
                //console.log("confirm_passwordError");
                $("#pass_info").css("color", "red");
                $("#password").css("background-color", "#ffebeb");
                $("#confirm_password").css("background-color", "#ffebeb");
                document.getElementById("pass_info").innerHTML = data.errors[key];
                longError = longError + data.errors[key] + " ";
              }  
              else if (key === 'nameError') 
              {
                //console.log("nameError");
                $("#name_info").css("color", "red");
                $("#name").css("background-color", "#ffebeb");
                document.getElementById("name_info").innerHTML = data.errors[key];
                longError = longError + data.errors[key] + " ";
              } 
              else if (key === 'email_uniqueError') 
              {
                //console.log("email_uniqueError");
                $("#email_info").css("color", "red");
                document.getElementById("email_info").innerHTML = data.errors[key];
                $("#email").css("background-color", "#ffebeb");
                longError = longError + data.errors[key] + " ";
              }




          
          });
          console.log(longError);
          // Установка общего сообщения об ошибке, если не было ошибок в полях
          if (!hasFieldErrors) {
            //$("#result-message").css({ "opacity": "1", "display": "block" });
            document.getElementById('result-message').innerHTML = '<p style=\'transition: all 1s ease-out;\'>' + longError + '</p>';
          }
        }
      })
      .catch(error => {
        $("#result-message").css("display", "block");
        $("#reg-form").css("color", "rgb(9, 159, 28)"); // Показать сообщение
        document.getElementById('result-message').innerHTML = "'<p>' + data.message + '</p>'";
        console.error('Ошибка AJAX запроса: ', error);
      });
  });
});