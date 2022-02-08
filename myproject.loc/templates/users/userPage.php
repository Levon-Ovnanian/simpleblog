<?php include __DIR__ . '/../main/header.php'; ?>

<?php if($error): ?>
    <?php if ($author):?>
        <img src="http://176.36.123.219/uploads/profile_images/<?= $author->getIconPath(); ?>" height="80px">
        <h2><?= $author->getNickName(); ?></h2>
        <h3>
            Cтатус пользователя: <span style="color: red;"><?= $user->getStatus(); ?></span><br>
            Рейтинг пользователя: <?= $user->getRating(); ?><br>
            Всего комментариев от пользователя: <?= $commentsCount->count;?>
            <br>
            <br>
            Всего статей: <?= $articlesCount; ?><br>
        </h3>
        <form action="/user/<?= $author->getId(); ?>" method="post">
        <p><select size="1" name="orderBy">
        <?php if ($orderBy === 'DESC' || $orderBy === null): ?>     
                <option selected value="DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'ASC'): ?>
                <option value= "DESC">Сначала новые</option>
                <option selected value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withComments'): ?>
                <option value= "DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option selected value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withCommentsASC'): ?>
                <option value= "DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option selected value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php endif; ?>            
        </select></p>
            <p><input type="submit" value="сортировать"></p>
        </form>
    <?php endif; ?>      
    <h3 style="text-align: center;"><?= $error; ?></h3>
<?php else: ?>
    <img src="http://176.36.123.219/uploads/profile_images/<?= $author->getIconPath(); ?>" height="80px">
    <h2><?= $author->getNickName(); ?></h2>
    <h3>
        Cтатус пользователя: <span style="color: red;"><?= $user->getStatus(); ?></span><br>
        Рейтинг пользователя: <?= $user->getRating(); ?><br>
        Всего комментариев от пользователя: <?= $commentsCount->count;?>
    </h3>
    <?php if ($user AND $user->getId() !== $author->getId()): ?>
        <?php if ($follower): ?>
            <?php if ($isAlreadyFollowed): ?>       
                <p>Вы уже подписаны</p>
                <form action="/articles/<?= $articles[0]->getId(); ?>/unfollowauthor/user/<?= $author->getId(); ?>" method="post">    
                    <input name ="unfollow" type="submit" value="unfollow"></input>
                </form>
            <?php else:?>    
                <p>Подписаться</p>    
                <form action="/articles/<?= $articles[0]->getId(); ?>/followauthor/user/<?= $author->getId(); ?>" method="post">    
                    <input name ="follow" type="submit" value="follow"></input>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <form action="/articles/<?= $articles[0]->getId(); ?>/followauthor/user/<?= $author->getId(); ?>" method="post">    
                <input name ="follow" type="submit" value="follow"></input>
            </form>
        <?php endif; ?>
    <?php endif; ?>       
    <h3>Всего статей: <?= $articlesCount; ?></h3>
    <form action="/user/<?= $author->getId(); ?>" method="post">
    <p><select size="1" name="orderBy">
        <?php if ($orderBy === 'DESC' || $orderBy === null): ?>     
                <option selected value="DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'ASC'): ?>
                <option value= "DESC">Сначала новые</option>
                <option selected value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withComments'): ?>
                <option value= "DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option selected value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withCommentsASC'): ?>
                <option value= "DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option selected value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php endif; ?>            
        </select></p>
        <p><input type="submit" value="сортировать"></p>
    </form>
    <br>
    <?php for ($i = 0; $i != count($articles); $i++): ?>
        <h2><a href="/articles/<?= $articles[$i]->getId(); ?>"><?= $articles[$i]->getName(); ?></a> &nbsp;&nbsp;&nbsp;
            <?php if (!empty($comments[$i])):?>
                <span style="font-size: medium;"><?= $comments[$i][0]->getCount();?></span><img src="http://176.36.123.219/service_images/message-4221533.svg" height="20px">
            <?php else: ?>
                <span style="font-size: medium;"><?php echo('0');?></span><img src="http://176.36.123.219/service_images/message-4221533.svg" height="20px">
            <?php endif; ?>        
        </h2>
        <p><?= $articles[$i]->getShortText(300); ?></p>
        <hr>
    <?php endfor; ?>   
<?php endif; ?>

<?php include __DIR__ . '/../main/footer.php'; ?>