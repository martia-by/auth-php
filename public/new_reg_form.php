<?php

?>
<script src="js/registration.js" defer></script>
<div id="cont_reg_form">
    <h2>Регистрация пользователя</h2>
    <form id="regForm" action="" method="POST">
        <div class="form-field">
            <label for="login">* Логин:</label>
            <input type="text" id="login" name="login" required>
            <div class="info" id="login_info">Минимум 6 символов, обязательно цифры и буквы.</div>
        </div>

        <div class="form-field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <div class="info" id="email_info">Введите ваш email.</div>
        </div>

        <div class="form-field">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <div class="info" id="password_info">Введите ваш пароль.</div>
        </div>

        <div class="form-field">
            <label for="password_confirm">Подтверждение пароля:</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
            <div class="info" id="password_confirm_info">Подтвердите ваш пароль.</div>
        </div>

        <div class="form-field">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required>
            <div class="info" id="name_info">Минимум 2 символа. Только буквы.</div>
        </div>
        <button type="submit" id="submit" name="submit">Зарегистрироваться</button>
    </form>
</div>

<div id="success_reg" class="disp_none"><h2>Успешный успех</h2></div>