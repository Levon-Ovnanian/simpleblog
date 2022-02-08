<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Simple blog</title>
        <link rel="stylesheet" href="/styles.css">

    </head>
    <body>
        <table class="layout">
            <tr >
                <td colspan="2" class="header">
                    Simple blog
                </td>
            </tr>
            <tr>
                <td  colspan="2" style="text-align: right">
                    <?= $date; ?>
                    <?php if (!empty($user)): ?>
                        <a href="/users/cabinet/personalpage">Кабинет пользователя</a>
                        Привет, <?= $user->getNickname(); ?> | <a href="/users/logout">Выйти</a>
                    <?php else: ?>
                    <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
                    <?php endif; ?>        
            </tr>
            
            <tr>
                <td>