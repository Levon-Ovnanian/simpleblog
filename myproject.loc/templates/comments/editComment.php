<?php include __DIR__ . '/../main/header.php'; ?>

<img src="http://176.36.123.219/uploads/profile_images/<?= $comment->getUserId()->getIconPath(); ?>" height="80px">
<p style="padding-left: 10px;"><?= $comment->getUserId()->getNickname(); ?></p>
<p style="border: 1px solid black;"><?= $comment->getText(); ?></p>
<p><?= $comment->getCreatedAt(); ?></p>
<?php if(!empty($error)): ?>
    <div style="color: red;"><?= $error; ?></div>
<?php endif; ?>
<br> 
<form action="/article/<?= $article->getId(); ?>/editcomment/<?= $comment->getId(); ?>" method="post">
    <label for="text">Окно редактирования комментария</label><br>
    <textarea name="text" id="text" rows="7" cols="50" value="<?= $_POST['text']?>"><?= $comment->getText(); ?></textarea><br>
    <br>
<input type="submit" value="Отправить">
</form>

<?php include __DIR__ . '/../main/footer.php'; ?> 

 
