document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('authForm');
  form.addEventListener('submit', function (event) {
    event.preventDefault();  // Предотвращаем стандартную отправку формы
    const formData = new FormData(form); // Собираем данные формы

    fetch('app/login.php', { // Путь к серверному скрипту, который будет обрабатывать данные
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })

      .then(response => response.json())
      .then(data => {
        console.log(data); // Обработка данных, полученных от сервера
        $("#login_info").html('');
        $("#password_info").html('');
        if (data.success) {
          $("#auth_success").css("display", "block");
          $("#cont_auth_form").css("display", "none");
          $("#auth_success").html("Привет, " + data.username + "!");
        } else {
          // Обработка ошибок
          console.log(data.errorLogin);
          if (data.errorLogin) {
            $("#login_info").html(data.errorLogin);
          } else if (data.errorPassword) {
            $("#password_info").html(data.errorPassword);
          }
          

      };
  });
});
});