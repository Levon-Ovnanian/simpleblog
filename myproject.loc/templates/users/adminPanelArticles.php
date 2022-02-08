<td style="overflow: auto;"> 
    <div class= "adminPanelArticles">
        <h3>Всего статей: <?= $articlesCount; ?></h3>
        <p><strong>Название статьи</strong></p>
        <?php if ($error): ?>
            <form action="/adminpanel" method="post">
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
                <span>поиск по:</span>
                <p><select size="1" name="mainSearchPanel">    
                    <option value="name">названию статьи</option>
                    <option value= "text">тексту статьи</option>
                    <option value= "nickname">автору статьи</option><input type="text" name="mainSearchPanelArguments">
                </select></p>
                <p><input type="submit" value="сортировать"></p>
            </form>      
                <p><?= $error; ?></p>
        <?php else: ?>    
            <form action="/adminpanel" method="post">
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
                <span>поиск по:</span>
                <p><select size="1" name="mainSearchPanel">    
                    <option value="name">названию статьи</option>
                    <option value= "text">тексту статьи</option>
                    <option value= "nickname">автору статьи</option><input type="text" name="mainSearchPanelArguments">
                </select></p>
                <p><input type="submit" value="сортировать"></p>     
            </form>
            <?php foreach ($articles as $article): ?>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <?php if ($comment[0]-> getArticleId() === $article->getId()): ?> 
                            <span style="font-size: medium;"><?= count($comment); ?>                
                            </span><img src="http://176.36.123.219/service_images/message-4221533.svg" height="20px">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>            
                <p>"<a href="/articles/<?= $article->getId()?>"><?= $article->getName(); ?>"</a></p>
                &nbsp;&nbsp;&nbsp;
                <p><?= $article->getShortText(150); ?></p>
                <p>Автор: <a href=/user/<?= $article->getAuthorId()->getId(); ?>><?= $article->getAuthorId()->getNickname(); ?></a></p>
                <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a>|<a href="/articles/<?= $article->getId()?>/delete" style="color: red;">Удалить</a> 
                <hr>
                <br>
            <?php endforeach; ?>
        <?php endif; ?>    
    </div>
 


    