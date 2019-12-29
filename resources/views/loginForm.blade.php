<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 25.12.19
 * Time: 16:58
 */
?>
<style>
    html. body {
        width: 100%;
        height: 100%;
    }
    .container {
        width: 450px;
        height: 200px;
        position: absolute;
        top: calc(50% - 100px);
        left: calc(50% - 225px);
    }
</style>

<body>
<div class="container">
    <div class="wrapper">
        <h2>Авторизация: </h2>
        <form method="post">
            <input type="text" name="login" placeholder="логин">
            <input type="password" name="password" placeholder="пароль">
            <input type="submit" value="войти">
        </form>
    </div>
</div>
</body>