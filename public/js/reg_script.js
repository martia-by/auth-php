document.getElementById('regForm').addEventListener('input', function () {
  

  const formData = new FormData(this);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'app/reg.php', true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      // Массив идентификаторов полей
      var fields = ['login_info', 'password_info', 'password_confirm_info', 'email_info', 'name_info'];

      // Перебор всех полей и добавление или удаление класса ошибки в зависимости от того, есть ли ошибка
      fields.forEach(function (fieldId) {
        var fieldElement = document.getElementById(fieldId);
        var fieldValue = response[fieldId.replace('_info', '')]; // Получаем значение из объекта response по ключу, соответствующему идентификатору поля
        fieldElement.innerHTML = fieldValue;

      });

      if ((response.login != null) || (response.email != null) || (response.password != null) || (response.password_confirm != null) || (response.name != null)) {
        document.getElementById('submit').disabled = true;
      } else {
        document.getElementById('submit').disabled = false;
      }

    } else {
      console.error('Error:', xhr.status, xhr.statusText);
    }
  };
  xhr.send(formData);
});


document.getElementById('regForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Предотвращаем отправку формы по умолчанию

  const formData = new FormData(this);
  formData.append('submit', 'send');
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'app/reg.php', true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);

      // Проверяем наличие ошибок
      if (response.login == null && 
        response.email == null && 
        response.password == null && 
        response.password_confirm == null && 
        response.name == null && 
        response.created == true) {
        // Если ошибок нет, отправляем пользователя на регистрацию и получили ответ об успешном создании записи
        document.getElementById('cont_reg_form').classList.add('fadeout');
        // Добавляем класс для медленного исчезновения через 2 секунды
        setTimeout(function () {
          document.getElementById('cont_reg_form').classList.add('disp_none');
          document.getElementById('success_reg').classList.add('fadein');
          document.getElementById('success_reg').classList.remove('disp_none');
        }, 2000);
      }
    } else {
      console.error('Error:', xhr.status, xhr.statusText);
    }
  };
  xhr.send(formData);
});