<?php include __DIR__ . '/../main/header.php'; ?>

<?php if (empty($error)): ?>
    <h1>Вы не авторизованы</h1>
    Для доступа к этой странице нужно <a href="/users/login">войти на сайт</a>
<?php else: ?>
    <h2 style="text-align: center;"><?= $error; ?></h2>
<?php endif; ?>
<?php if (!empty($link)): ?>
    <p style="text-align: center;"><?= $link; ?></p>
<?php endif; ?>
    
<?php include __DIR__ . '/../main/footer.php'; ?>