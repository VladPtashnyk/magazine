<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<div class="wrapper">
    <form action="register" method="POST" class="form">
        <h1>Реєстрація</h1>
        <input type="text" name="firstName" placeholder="Введіть ім'я користувача">
        <input type="text" name="secondName" placeholder="Введіть прізвище користувача">
        <input type="tel" name="phone" placeholder="123-4567-8901">
        <input type="email" name="email" placeholder="Введіть email">
        <input type="password" name="password" placeholder="Введіть пароль">
        <input type="text" name="id_status" placeholder="Введіть статус">
        <input type="submit" name="submit" value="Зареєструватися"> 
        <input type="submit" name="submitLogin" value="Увійти"> 
    </form>
</div>