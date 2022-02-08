<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Simple blog</title>
        <link rel="stylesheet" href="/styles.css">
    </head>
    <body>
        <table class="layout">
            <tr>
                <td colspan="3" class="header">
                     Simple blog
                </td>  
            </tr>
            <tr>
                <td colspan="3" style="text-align: right">
                    <?php if (!empty($user)): ?>
                        <a href="/users/cabinet/personalpage">Кабинет пользователя</a>
                        Привет, <?= $user->getNickname(); ?> | <a href="/users/logout">Выйти</a>
                    <?php else: ?>
                        <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
        