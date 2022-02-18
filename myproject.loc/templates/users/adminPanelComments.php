<td style="overflow: auto;"> 
   <div class="adminPanelComment">
    <h3>Всего комментариев: <?= $commentsCount; ?></h3>
    <p><strong>Комментарии</strong></p>
    <?php if (!empty($comments)): ?>
        <?php for ($i = 0; $i <count($comments); $i++): ?>
            <span style="font-size: medium;"><?= count($comments[$i]);?></span><img src="http://simpleblog.sytes.net/service_images/message-4221533.svg" height="20px"><br>
            <a href ="/articles/<?= $comments[$i][0]->getArticleId(); ?>" style="color: darkblue;"><span style="word-wrap: break-word;"><?= $comments[$i][0]->getArticle()->getName(); ?></span></a>
            &nbsp;&nbsp;&nbsp;
           
            <?php foreach ($comments[$i] as $commentData): ?>     
                <?php if ($commentData->getSourceCommentId()): ?>
                    Ответ на комментарий от <span style="color: blue;"><?= $commentData->getSourceCommentUser()->getNickname(); ?></span><br>
                    <p> <?= $commentData->getShortText(150); ?></p>   
                    <span>автор комментария :<?= $commentData->getUserId()->getNickname(); ?></span><br>
                    <span><?= $commentData->getCreatedAt(); ?></span><br>
                    <?php if ($commentData->getRedactedAt()): ?>
                        <span>дата редактирования:<br>
                        <?= $commentData->getRedactedAt() ; ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="word-wrap: break-word;"><?= $commentData->getShortText(150); ?></p> 
                    <span>автор комментария :<?= $commentData->getUserId()->getNickname(); ?></span>
                    <br>
                    <span> <?= $commentData->getCreatedAt(); ?></span><br>
                    <?php if ($commentData->getRedactedAt()): ?>
                        <span>дата редактирования:<br>
                        <?= $commentData->getRedactedAt() ; ?></span>
                    <?php endif; ?>            
                <?php endif; ?>
                <hr>
                <a href="/article/<?= $commentData->getArticleId(); ?>/editcomment/<?= $commentData->getId(); ?>/<?= $currentPageNum; ?>/<?= $orderBy; ?>/<?= $searchPanelName?>/<?= $searchPanelArgs; ?>">Редактировать</a>
                | <a style="color: red;" href="/comments/<?= $commentData->getId()?>/delete/<?= $currentPageNum; ?>/<?= $orderBy; ?>/<?= $searchPanelName?>/<?= $searchPanelArgs?>" style="color: red;">Удалить</a> 
                <br>
                <br>
            <?php endforeach; ?>        
        <?php endfor; ?>
    <?php elseif (empty($articles)) : ?>      
        <p>Комментариев пока нет</p>    
    <?php else: ?>
        <p>Комментариев в статьях на этой странице нет</p>
    <?php endif; ?>
   </div>
</td>


 