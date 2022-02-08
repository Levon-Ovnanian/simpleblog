<?php include __DIR__ . '/../main/header.php'; ?>

<img src="http://176.36.123.219/uploads/profile_images/<?= $articles->getAuthorId()->getIconPath(); ?>" height="80px">
<br>
<h2><a href=/user/<?= $articles->getAuthorId()->getId(); ?>><?= $articles->getAuthorId()->getNickname(); ?></a></h2>
Рейтинг пользователя: <?= $articles->getAuthorId()->getRating(); ?><br>
Cтатус пользователя: <span style="color: red;"><?= $articles->getAuthorId()->getStatus(); ?></span><br>
<h1><?= $articles->getName(); ?></h1>

<a href="/articles/<?= $articles->getId(); ?>/plusarticle/<?= $articles->getAuthorId()->getId(); ?>/0/null/null/null"><img src="http://176.36.123.219/service_images/arrow_up154593.svg" height="10px"></a><?= $articles->getPlus(); ?></a>
<a href="/articles/<?= $articles->getId(); ?>/minusarticle/<?= $articles->getAuthorId()->getId(); ?>/0/null/null/null"><img src="http://176.36.123.219/service_images/arrow_down154593.svg" height="10px"></a><?= $articles->getMinus(); ?></a>
<p><?= $articles->getParsedText(); ?></p>
<hr>

<?php if ($user AND $user->getId() !== $articles->getAuthorId()->getId()): ?>
    <?php if ($follower): ?>
        <?php if ($isAlreadySubscribed): ?>       
            <p>Вы уже подписаны</p>
            <form action="/articles/<?= $articles->getId(); ?>/unfollowauthor/articles/<?= $articles->getId(); ?>" method="post">    
                <input name ="unfollow" type="submit" value="unfollow"></input>
            </form>
        <?php else:?>    
            <p>Подписаться</p>    
            <form action="/articles/<?= $articles->getId(); ?>/followauthor/articles/<?= $articles->getId(); ?>" method="post">    
                <input name ="follow" type="submit" value="follow"></input>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <form action="/articles/<?= $articles->getId(); ?>/followauthor/articles/<?= $articles->getId(); ?>" method="post">    
            <input name ="follow" type="submit" value="follow"></input>
        </form>
    <?php endif; ?>
<?php endif; ?>       
<br> 
<?php include __DIR__ . '/../main/comments.php'; ?>
    
<?php if (!empty($user AND $user->isAdmin())) : ?>  
    <p><a href="/articles/<?= $articles->getId(); ?>/edit">Редактировать статью</a> </p>
    <p><a href="/articles/<?= $articles->getId(); ?>/delete" style="color: red;">Удалить статью</a> </p>
<?php endif; ?>
    
<?php include __DIR__ . '/../main/footer.php'; ?>