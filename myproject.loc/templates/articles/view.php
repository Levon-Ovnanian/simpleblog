<?php include __DIR__ . '/../main/header.php'; ?>

<img src="http://simpleblog.sytes.net/uploads/profile_images/<?= $articles->getAuthorId()->getIconPath(); ?>" height="80px">
<br>
<h2><a href=/user/<?= $articles->getAuthorId()->getId(); ?>><?= $articles->getAuthorId()->getNickname(); ?></a></h2>
Рейтинг пользователя: <?= $articles->getAuthorId()->getRating(); ?><br>
Cтатус пользователя: <span style="color: red;"><?= $articles->getAuthorId()->getStatus(); ?></span><br>
<h1 style="word-wrap: break-word;"><?= $articles->getName(); ?></h1>

<a href="/articles/<?= $articles->getId(); ?>/plusarticle/<?= $articles->getAuthorId()->getId(); ?>/0/null/null/null"><img src="http://simpleblog.sytes.net/service_images/arrow_up154593.svg" height="10px"></a><?= $articles->getPlus(); ?></a>
<a href="/articles/<?= $articles->getId(); ?>/minusarticle/<?= $articles->getAuthorId()->getId(); ?>/0/null/null/null"><img src="http://simpleblog.sytes.net/service_images/arrow_down154593.svg" height="10px"></a><?= $articles->getMinus(); ?></a>
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
<?php include __DIR__ . '/../main/footer.php'; ?>