<td style="overflow: auto;"> 
   <div class="adminPanelComment">
    <h3>Всего комментариев: <?= $commentsCount; ?></h3>
    <p><strong>Комментарии</strong></p>
    <?php if (!empty($comments)): ?>
        <?php for ($i = 0; $i <count($comments); $i++): ?>
            <p style="color: darkblue;"> <a href ="/articles/<?= $comments[$i][0]->getArticleId(); ?>">
                <?= $comments[$i][0]->getArticle()->getName(); ?></a>
                &nbsp;&nbsp;&nbsp;
                <span style="font-size: medium;"><?= count($comments[$i]);?>                
                </span><img src="http://176.36.123.219/service_images/message-4221533.svg" height="20px">
            </p>
            <?php foreach ($comments[$i] as $commentData): ?>     
                <?php if ($commentData->getSourceCommentId()): ?>
                    Ответ на комментарий от <span style="color: blue;"><?= $commentData->getSourceCommentUser()->getNickname(); ?></span>
                    <br>
                    <p> <?= $commentData->getShortText(150); ?></p>   
                    <span>автор комментария :<?= $commentData->getUserId()->getNickname(); ?></span>
                    <br>
                    <span> <?= $commentData->getCreatedAt(); ?></span>
                    <br>
                    <?php if ($commentData->getRedactedAt()): ?>
                        <span>дата редактирования:<br>
                        <?= $commentData->getRedactedAt() ; ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <?= $commentData->getShortText(150); ?></p> 
                    <span>автор комментария :<?= $commentData->getUserId()->getNickname(); ?></span>
                    <br>
                    <span> <?= $commentData->getCreatedAt(); ?></span>
                    <br>
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
    <?php else : ?>      
        <p>Комментариев пока нет</p>
    <?php endif; ?>
   </div>
</td>


 