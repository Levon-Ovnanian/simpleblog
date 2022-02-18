<?php include __DIR__ . '/../main/header.php'; ?>

<img src="http://simpleblog.sytes.net/uploads/profile_images/<?= $sourceComment->getUserId()->getIconPath(); ?>" height="80px">
<p style="padding-left: 10px;"><?= $sourceComment->getUserId()->getNickname(); ?></p>
<p style="border: 1px solid black;"><?= $sourceComment->getText(); ?></p>
<p><?= $sourceComment->getCreatedAt(); ?></p>
<?php if(!empty($error)): ?>
    <div style="color: red;"><?= $error; ?></div>
<?php endif; ?>
<br> 
<form action="/article/<?= $article->getId(); ?>/answercomment/<?= $sourceComment->getId(); ?>" method="post">
    <label for="text">Ответ на комментарий:</label><br>
    <textarea name="text" id="text" rows="7" cols="50"></textarea><br>
    <br>
    <input type="submit" value="Отправить">
</form>
    
<?php include __DIR__ . '/../main/footer.php'; ?> 