<?php include __DIR__ . '/../users/AdminPanelHeader.php'; ?>
<td>
    <?php if(!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <img src="http://simpleblog.sytes.net/uploads/profile_images/<?= $user->getIconPath(); ?>" height="80px">
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
<td>
    <div style="overflow:auto; height: 600px; width: 300px;">
        <strong>
            Ваш статус: <span style="color: red;"><?= $user->getStatus(); ?></span><br>
            Тип аккаунта: <?= $user->getRole(); ?><br>
            Ваш рейтинг: <?= $user->getRating(); ?><br>
            Всего статей: <?= $articlesCount[0][0]->count; ?><br>
            <?php if ($commentsCount !== null): ?>
                Всего комментариев: <?= $commentsCount[0][0]->count;?>
            <?php else: ?>
                Всего комментариев: 0
            <?php endif; ?>   
        </strong>   
        <br>
        <hr>
        <p><strong>Фолловеры:</strong></p>
        <?php if (!empty($followers[0])):?>
            <p>Количество фолловеров: <?= count($followers[0]); ?></p>
            <?php foreach($followers[0] as $follower):?>
                <img src="http://simpleblog.sytes.net/uploads/profile_images/<?= $follower->getIconPath(); ?>" height="40px">
                <p>Логин: <a href = "/user/<?= $follower->getId(); ?>"><?= $follower->getNickName(); ?></a>
                <br>
                <br>
            <?php endforeach;?>               
        <?php endif;?>
        <hr>
        <p><strong>Подписки:</strong></p>
        <?php if (!empty($subscribes[0])):?>
            <p>Количество авторов: <?= count($subscribes[0]); ?></p>
            <?php for ($x = 0; $x < count($subscribes[0]); $x++):?>
                <?php foreach($subscribes[0][$x] as $subscribe):?>
                    <img src="http://simpleblog.sytes.net/uploads/profile_images/<?= $subscribe->getIconPath(); ?>" height="40px">
                    <p>Логин: <a href = "/user/<?= $subscribe->getId(); ?>"><?= $subscribe->getNickName(); ?></a>
                    <br>
                    <hr>
                    <br>
                <?php endforeach;?>
            <?php endfor;?>
        <?php endif;?>
    </div>
</td>
 
<?php include __DIR__ . '/../users/personalPageFooter.php'; ?>