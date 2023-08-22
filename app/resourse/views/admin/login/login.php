<?php require_once('app/resourse/views/admin/header/header.php'); ?>

<body>
    <div class="wrapper">
        <form action="login" method="POST" class="form">
            <h1>Увійти</h1>
            <input type="tel" name="phone" placeholder="123-4567-8901">
            <input type="password" name="passwordUser" placeholder="Введіть пароль">
            <input type="submit" name="submit" value="Увійти">
            <input type="submit" name ="submitRegistration" value="Зареєструватися"> 
        </form>
    </div>
</body>