<?php include __DIR__ . '/../users/AdminPanelHeader.php'; ?>
<td>
    <?php if(!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <img src="http://176.36.123.219/uploads/profile_images/<?= $user->getIconPath(); ?>" height="80px">
    <h1><?= $user->getNickName(); ?></h1>
    <p>Загрузить аватар:</p>
    <form action="/users/cabinet/personalpage" method="post" enctype="multipart/form-data">
        <input type="file" name="attachment">
        <input type="submit">
    </form>
    <br>

    <form action="/users/cabinet/personalpage" method="post">
        <div>
            <p>Получать уведомление о новой статье авторов:</p>
            <?php if ($user->getEmailSendIfArticle()): ?>
                    <input type="radio" id = "send" name="EmailSendIfArticle" value="1" checked>
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfArticle" value="0">
                    <label for="dontsend">Нет</label>
            <?php else: ?>
                <input type="radio" id = "send" name="EmailSendIfArticle" value="1" >
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfArticle" value="0" checked>
                    <label for="dontsend">Нет</label>
            <?php endif; ?> 
        </div>

        <div>
            <p>Получать уведомление о новом комментарии:</p>
            <?php if ($user->getEmailSendIfComment()): ?>
                <input type="radio" id = "send" name="EmailSendIfComment" value="1" checked>
                <label for="send">Да</label>
                <input type="radio" id = "dontsend" name="EmailSendIfComment" value="0">
                <label for="dontsend">Нет</label>
            <?php else: ?>
                <input type="radio" id = "send" name="EmailSendIfComment" value="1" >
                <label for="send">Да</label>
                <input type="radio" id = "dontsend" name="EmailSendIfComment" value="0" checked>
                <label for="dontsend">Нет</label>
            <?php endif; ?> 
        </div>

        <div>
            <p>Получать уведомление о новом фолловере:</p>
            <?php if ($user->getEmailSendIfAddFollower()): ?>
                <input type="radio" id = "send" name="EmailSendIfAddFollower" value="1" checked>
                <label for="send">Да</label>
                <input type="radio" id = "dontsend" name="EmailSendIfAddFollower" value="0">
                <label for="dontsend">Нет</label>
            <?php else: ?>
                <input type="radio" id = "send" name="EmailSendIfAddFollower" value="1" >
                <label for="send">Да</label>
                <input type="radio" id = "dontsend" name="EmailSendIfAddFollower" value="0" checked>
                <label for="dontsend">Нет</label>
            <?php endif; ?>            
        </div>
        
        <div>
            <p>Получать уведомление об удалившемся фолловере:</p>
            <?php if ($user->getEmailSendIfDellFollower()): ?>
                <input type="radio" id = "send" name="EmailSendIfDellFollower" value="1" checked>
                <label for="send">Да</label>
                <input type="radio" id = "dontsend" name="EmailSendIfDellFollower" value="0">
                <label for="dontsend">Нет</label>
            <?php else: ?>
                <input type="radio" id = "send" name="EmailSendIfDellFollower" value="1" >
                <label for="send">Да</label>
                <input type="radio" id = "dontsend" name="EmailSendIfDellFollower" value="0" checked>
                <label for="dontsend">Нет</label>
            <?php endif; ?>            
        </div>
        <br>
        <input type="submit"></input>
    </form>
</td>
<td style="overflow: auto;" width="350px">
    <strong>
        Ваш статус: <span style="color: red;"><?= $user->getStatus(); ?></span><br>
        Ваш рейтинг: <?= $user->getRating(); ?><br>
        Всего статей: <?= $articlesCount[0][0]->count; ?><br>
        Всего комментариев <?= $commentsCount[0][0]->count; ?>
    </strong>
    <br>
    <hr>
    <p>Фолловеры:</p>
    <?php if (!empty($followers[0])):?>
        <p>Количество фолловеров: <?= count($followers[0]); ?></p>
        <?php foreach($followers[0] as $follower):?>
            <img src="http://176.36.123.219/uploads/profile_images/<?= $follower->getIconPath(); ?>" height="40px">
            <p>Логин: <?= $follower->getNickName(); ?>
            <p>Почта: <?= $follower->getEmail(); ?>
            <br>
            <hr>
            <br>
        <?php endforeach;?>               
    <?php endif;?>
    <hr>
    <p>Подписки:</p>
    <?php if (!empty($subscribes[0])):?>
        <p>Количество авторов: <?= count($subscribes[0]); ?></p>
        <?php for ($x = 0; $x < count($subscribes[0]); $x++):?>
            <?php foreach($subscribes[0][$x] as $subscribe):?>
                <img src="http://176.36.123.219/uploads/profile_images/<?= $subscribe->getIconPath(); ?>" height="40px">
                <p>Логин: <?= $subscribe->getNickName(); ?>
                <p>Почта: <?= $subscribe->getEmail(); ?>
                <br>
                <hr>
                <br>
            <?php endforeach;?>
        <?php endfor;?>
    <?php endif;?>
</td>

<?php include __DIR__ . '/../users/personalPageFooter.php'; ?>