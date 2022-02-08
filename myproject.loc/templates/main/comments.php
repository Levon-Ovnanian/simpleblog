<form action="/articles/<?= $articles->getId(); ?>/comments" method="post">
  
    <p><strong>Комментарии к статье:</strong></p>
    <?php if (!empty($comments)): ?>

        <?php for ($i = 0; $i < count($comments); $i++): ?>
            <?php if ($comments[$i]->getSourceCommentId()): ?>
                <div style="padding-left: 50px;">
                    <span id= "<?= $comments[$i]->getId(); ?>"></span>
                    <p><img src="http://176.36.123.219/uploads/profile_images/<?=$comments[$i]->getUserId()->getIconPath(); ?>" height="50px">
                    <br>
                    <?= $comments[$i]->getUserId()->getNickname(); ?></p>
                    <div style="border: solid grey 1px;">
                        <a href="#<?= $comments[$i]->getSourceCommentId()?>"><?=$comments[$i]->getSourceCommentUser()->getNickname()?></a> 
                        <?= $comments[$i]->getSourceComment()->getParsedText(); ?>
                    </div>
                    <?= $comments[$i]->getParsedText(); ?>
                    <a href="/article/<?= $articles->getId(); ?>/pluscomment/<?= $comments[$i]->getId(); ?>"><img src="http://176.36.123.219/service_images/arrow_up154593.svg" height="10px"></a><?= $comments[$i]->getPlus(); ?>
                    <a href="/article/<?= $articles->getId(); ?>/minuscomment/<?= $comments[$i]->getId(); ?>"><img src="http://176.36.123.219/service_images/arrow_down154593.svg" height="10px"></a><?= $comments[$i]->getMinus(); ?>         
                    <br><br>
                    <?php if($createdAtDates[$i][0] !== '0'): ?>   
                        <?php if($createdAtDates[$i][1] !== '0'): ?>
                            <span><?= ($createdAtDates[$i][0]);?> г. </span>
                            <span><?= ($createdAtDates[$i][1]);?> мес. назад</span>
                        <?php else: ?>
                            <span><?= ($createdAtDates[$i][0]);?> лет назад</span>
                        <?php endif; ?>    
                    <?php elseif($createdAtDates[$i][1] !== '0'): ?>   
                        <span><?= ($createdAtDates[$i][1]);?> мес. назад</span>
                    <?php elseif($createdAtDates[$i][2] !== '0'): ?>   
                        <span><?= ($createdAtDates[$i][2]);?> дн. назад</span>
                    <?php elseif($createdAtDates[$i][3] !== '0'): ?>  
                        <span><?= ($createdAtDates[$i][3]);?> ч.</span>
                        <span><?= ($createdAtDates[$i][4]);?> мин. назад</span> 
                    <?php elseif($createdAtDates[$i][4] !== '0'): ?>   
                        <span><?= ($createdAtDates[$i][4]);?> мин. назад</span>
                    <?php else : ?>
                        <span>только что</span>               
                    <?php endif; ?>    
                    <br>    
                    <?php if ($comments[$i]->getRedactedAt()): ?>
                        <span style="color: green;">редактировано:</span>
                        <br> 
                        <?php if($redactedAtDates[$i][0] !== '0'): ?>   
                            <?php if($redactedAtDates[$i][1] !== '0'): ?>
                                <span><?= ($redactedAtDates[$i][0]);?> г. </span>
                                <span><?= ($redactedAtDates[$i][1]);?> мес. назад</span>
                            <?php else: ?>
                                <span><?= ($redactedAtDates[$i][0]);?> лет назад</span>
                            <?php endif; ?>    
                        <?php elseif($redactedAtDates[$i][1] !== '0'): ?>   
                            <span><?= ($redactedAtDates[$i][1]);?> мес. назад</span>
                        <?php elseif($redactedAtDates[$i][2] !== '0'): ?>   
                            <span><?= ($redactedAtDates[$i][2]);?> дн. назад</span>
                        <?php elseif($redactedAtDates[$i][3] !== '0'): ?>  
                            <span><?= ($redactedAtDates[$i][3]);?> ч.</span>
                            <span><?= ($redactedAtDates[$i][4]);?> мин. назад</span> 
                        <?php elseif($redactedAtDates[$i][4] !== '0'): ?>   
                            <span><?= ($redactedAtDates[$i][4]);?> мин. назад</span>
                        <?php else : ?>
                            <span>только что</span>               
                        <?php endif; ?>
                    <br>     
                    <?php endif; ?>  
                    <br> 
                    <?php if (!empty($user)): ?>
                        <a href="/article/<?= $articles->getId(); ?>/answercomment/<?= $comments[$i]->getId(); ?>">Ответить</a>
                    <?php endif; ?>
                    <br>   
                </div>   
            <?php else: ?>
                <div>
                    <span id= "<?= $comments[$i]->getId(); ?>"></span>
                    <p><img src="http://176.36.123.219/uploads/profile_images/<?=$comments[$i]->getUserId()->getIconPath(); ?>" height="50px"><br>
                    <?= $comments[$i]->getUserId()->getNickname(); ?>
                    <br>
                    статус пользов.:<span style="color: red;"><?= $comments[$i]->getUserId()->getStatus(); ?></span>
                    <br>
                    рейтинг: <?= $comments[$i]->getUserId()->getRating(); ?>
                    <?= $comments[$i]->getParsedText(); ?>
                    </p>
                    
                    <a href="/article/<?= $articles->getId(); ?>/pluscomment/<?= $comments[$i]->getId(); ?>"><img src="http://176.36.123.219/service_images/arrow_up154593.svg" height="10px"></a><?= $comments[$i]->getPlus(); ?>
                    <a href="/article/<?= $articles->getId(); ?>/minuscomment/<?= $comments[$i]->getId(); ?>"><img src="http://176.36.123.219/service_images/arrow_down154593.svg" height="10px"></a><?= $comments[$i]->getMinus(); ?>         
                    <br><br>
                    <?php if($createdAtDates[$i][0] !== '0'): ?>   
                        <?php if($createdAtDates[$i][1] !== '0'): ?>
                            <span style="text-decoration: underline;"><?= ($createdAtDates[$i][0]);?> лет </span>
                            <span style="text-decoration: underline;"><?= ($createdAtDates[$i][1]);?> мес. назад</span>
                        <?php else: ?>
                            <span style="text-decoration: underline;"><?= ($createdAtDates[$i][0]);?> лет назад</span>
                        <?php endif; ?>    
                    <?php elseif($createdAtDates[$i][1] !== '0'): ?>   
                        <span style="text-decoration: underline;"><?= ($createdAtDates[$i][1]);?> мес. назад</span>
                    <?php elseif($createdAtDates[$i][2] !== '0'): ?>   
                        <span style="text-decoration: underline;"><?= ($createdAtDates[$i][2]);?> дней. назад</span>
                    <?php elseif($createdAtDates[$i][3] !== '0'): ?>  
                        <span style="text-decoration: underline;"><?= ($createdAtDates[$i][3]);?> час.</span>
                        <span style="text-decoration: underline;"><?= ($createdAtDates[$i][4]);?> мин. назад</span> 
                    <?php elseif($createdAtDates[$i][4] !== '0'): ?>   
                        <span style="text-decoration: underline;"><?= ($createdAtDates[$i][4]);?> мин. назад</span>
                    <?php else : ?>
                        <span style="text-decoration: underline;">только что</span>               
                    <?php endif; ?> 
                    <br>    
                    <?php if ($comments[$i]->getRedactedAt()): ?>
                        <span style="color: green;">редактировано:</span>
                        <br> 
                        <?php if($redactedAtDates[$i][0] !== '0'): ?>   
                            <?php if($redactedAtDates[$i][1] !== '0'): ?>
                                <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][0]);?> лет </span>
                                <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][1]);?> мес. назад</span>
                            <?php else: ?>
                                <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][0]);?> лет назад</span>
                            <?php endif; ?>    
                        <?php elseif($redactedAtDates[$i][1] !== '0'): ?>   
                            <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][1]);?> мес. назад</span>
                        <?php elseif($redactedAtDates[$i][2] !== '0'): ?>   
                            <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][2]);?> дней. назад</span>
                        <?php elseif($redactedAtDates[$i][3] !== '0'): ?>  
                            <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][3]);?> час.</span>
                            <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][4]);?> мин. назад</span> 
                        <?php elseif($redactedAtDates[$i][4] !== '0'): ?>   
                            <span style="text-decoration: underline;"><?= ($redactedAtDates[$i][4]);?> мин. назад</span>
                        <?php else : ?>
                            <span style="text-decoration: underline;">только что</span>               
                        <?php endif; ?>
                    <br>   
                    <?php endif; ?>  
                    <br> 
                    <?php if (!empty($user)): ?>
                        <a href="/article/<?= $articles->getId(); ?>/answercomment/<?= $comments[$i]->getId(); ?>">Ответить</a>
                    <?php endif; ?>
                    <br>   
                </div>
            <?php endif; ?>
            <hr>
        <?php endfor ?>
        
    <?php else : ?>
        <p>Комментариев пока нет</p>
    <?php endif; ?>
        
    <?php if (!empty($user)): ?>
        <?php if(!empty($error)): ?>
            <div style="color: red;"><?= $error ?></div>
        <?php endif; ?>
        <label for="text">Новый комментарий</label><br>
        <textarea name="text" id="text" rows="7" cols="50" value="<?= $_POST['text']; ?>"></textarea><br>
        <br>
            
        <input type="submit" value="Отправить">
    <?php else :?>
        <p>Авторизуйтесь, чтобы оставить комментарий</p>
    <?php endif; ?>
        
</form>
        
