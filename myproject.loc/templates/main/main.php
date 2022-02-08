<tr>
    <td colspan="2">
        <div>
            <h2 style="text-align: center;">Привет! Добро пожаловать в мой Simple blog!</h2>
            <h3 style="text-align: center;">
                Этот сайт - мой pet проект, поэтому не стесняйся его тестировать :)
                <br>
                <br>
                Посети мой репозиторий GitHub если нужен README файл или исходный код  
                <a href="https://github.com/Levon-Ovnanian/myproject">GitHub</a>
            </h3>     
        </div>
    </td>
</tr>

<?php include __DIR__ . '/header.php'; ?>

<?php if ($error): ?>
    <form action="/" method="post">
        <p><select size="1" name="orderBy">
            <?php if ($orderBy === 'ratingDESC'): ?>
                <option selected value="ratingDESC">Только с высоким рейтингом</option>
                <option value="DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif ($orderBy === 'DESC' || $orderBy === null): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
                <option selected value="DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'ASC'): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
                <option value= "DESC">Сначала новые</option>
                <option selected value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withComments'): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
                <option value= "DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option selected value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withCommentsASC'): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
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
    <h3><?= $error;?></h3>
<?php else: ?>

    <form action="/" method="post">
        <p><select size="1" name="orderBy">
            <?php if ($orderBy === 'ratingDESC'): ?>
                <option selected value="ratingDESC">Только с высоким рейтингом</option>
                <option value="DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif ($orderBy === 'DESC' || $orderBy === null): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>          
                <option selected value="DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'ASC'): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
                <option value= "DESC">Сначала новые</option>
                <option selected value= "ASC">Сначала старые</option>
                <option value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withComments'): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
                <option value= "DESC">Сначала новые</option>
                <option value= "ASC">Сначала старые</option>
                <option selected value= "withComments">Сначала новые с комментариями</option>
                <option value= "withCommentsASC">Сначала старые с комментариями</option>
            <?php elseif($orderBy === 'withCommentsASC'): ?>
                <option value="ratingDESC">Только с высоким рейтингом</option>     
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
    
    <h3>Всего статей: <?= $articlesCount; ?></h3>
    <?php for ($i = 0; $i != count($articles); $i++): ?>
        <h2><a href="/articles/<?= $articles[$i]->getId(); ?>"><?= $articles[$i]->getName(); ?></a>&nbsp;&nbsp;&nbsp;
            <?php if (!empty($comments[$i])):?>
                <span style="font-size: medium;"><?= $comments[$i][0]->getCount();?></span><img src="http://176.36.123.219/service_images/message-4221533.svg" height="20px">
            <?php else: ?>
                <span style="font-size: medium;"><?php echo('0');?></span><img src="http://176.36.123.219/service_images/message-4221533.svg" height="20px">
            <?php endif; ?>        
        </h2>
        <a href="/articles/<?= $articles[$i]->getId(); ?>/plusarticle/<?= $articles[$i]->getAuthorId()->getId(); ?>/<?= $currentPageNum; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><img src="http://176.36.123.219/service_images/arrow_up154593.svg" height="10px"></a><?= $articles[$i]->getPlus(); ?>
        <a href="/articles/<?= $articles[$i]->getId(); ?>/minusarticle/<?= $articles[$i]->getAuthorId()->getId(); ?>/<?= $currentPageNum; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><img src="http://176.36.123.219/service_images/arrow_down154593.svg" height="10px"></a><?= $articles[$i]->getMinus(); ?>   
        <p><?= $articles[$i]->getShortText(300); ?></p>
        <p>Автор:<a href=/user/<?= $articles[$i]->getAuthorId()->getId(); ?>><?= $articles[$i]->getAuthorId()->getNickname(); ?></a>
        <br>
        Cтатус пользователя: <span style="color: red;"><?= $articles[$i]->getAuthorId()->getStatus(); ?></span><br>
        Рейтинг пользователя: <?= $articles[$i]->getAuthorId()->getRating(); ?><br>
        <hr>
    <?php endfor; ?>

<?php endif;?>

<div style="text-align: center">   
    <?php if ($lastPage < 6): ?>
        <?php if ($previousPageLink !== null): ?>
            <a href="/1/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><<</a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?= $previousPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">&lt;Туда</a>     
            &nbsp;&nbsp;&nbsp;
        <?php else: ?>
            <span style="color: grey">&lt;&lt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">&lt;Туда</span>
            &nbsp;&nbsp;&nbsp;
        <?php endif; ?>

        <?php if ($lastPage === 1): ?>
            <a href="/<?= $currentPageNum; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum; ?></a>         
            
        <?php elseif ($lastPage === 2): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
            <?php endif; ?>

        <?php elseif ($lastPage === 3): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 3): ?>
                <a href="/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
            <?php endif; ?>     
            
        <?php elseif ($lastPage === 4): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 3; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
            <?php elseif ($currentPageNum === 3): ?>
                <a href="/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 4): ?>
                <a href="/<?= $currentPageNum - 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>   
            <?php endif; ?>

        <?php elseif ($lastPage === 5): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 4; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 3; ?></a>
            <?php elseif ($currentPageNum === 3): ?>
                <a href="/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
            <?php elseif ($currentPageNum === 4): ?>
                <a href="/<?= $currentPageNum - 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 5): ?>
                <a href="/<?= $currentPageNum - 4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 4; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>          
            <?php endif; ?>    
        <?php endif; ?>

        <?php if ($nextPageLink !== null): ?>
            &nbsp;&nbsp;&nbsp;
            <a href="<?= $nextPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">Сюда&gt;</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/<?= $lastPage; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">>></a>
        <?php else: ?>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">Сюда&gt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">>>&gt;</span>
        <?php endif; ?>

    <?php else:?>
        <?php if ($previousPageLink !== null): ?>
            <a href='/'><<</a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?= $previousPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">&lt;Туда</a>     
            &nbsp;&nbsp;&nbsp;
            <?php if ($currentPageNum >= 3 AND $currentPageNum !== $lastPage AND $currentPageNum !== $lastPage - 1): ?>
                <a href="/<?= $currentPageNum -2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -2; ?></a> 
                &nbsp;&nbsp;&nbsp;   
            <?php elseif ($currentPageNum === $lastPage): ?>
                <a href="/<?= $currentPageNum -4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -4; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum -3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum -2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -2; ?></a>
                &nbsp;&nbsp;&nbsp; 
            <?php elseif ($currentPageNum === $lastPage - 1): ?>
                <a href="/<?= $currentPageNum -3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/<?= $currentPageNum -2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -2; ?></a>
                &nbsp;&nbsp;&nbsp; 
            <?php endif; ?>  
                <a href="/<?= $currentPageNum -1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -1; ?></a>
                &nbsp;&nbsp;&nbsp;
        <?php else: ?>
            <span style="color: grey">&lt;&lt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">&lt;Туда</span>
            &nbsp;&nbsp;&nbsp;
        <?php endif; ?>

        <?= $currentPageNum; ?>
        &nbsp;&nbsp;&nbsp;

        <?php if ($currentPageNum === 1): ?>
            <a href="/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
            <a href="/<?= $currentPageNum +2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +2; ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="/<?= $currentPageNum +3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +3; ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="/<?= $currentPageNum +4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +4; ?></a>
            &nbsp;&nbsp;&nbsp;
        <?php elseif ($currentPageNum === 2): ?> 
            <a href="/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
            <a href="/<?= $currentPageNum +2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +2; ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="/<?= $currentPageNum +3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +3; ?></a>
            &nbsp;&nbsp;&nbsp;
        <?php elseif ($currentPageNum === $lastPage - 1): ?>
            <a href="/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
        <?php elseif ($currentPageNum !== $lastPage):?>
            <a href="/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
            <a href="/<?= $currentPageNum +2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +2; ?></a>
            &nbsp;&nbsp;&nbsp;
        <?php endif; ?>
        
        <?php if ($nextPageLink !== null): ?>
            <a href="<?= $nextPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">Сюда&gt;</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/<?= $lastPage; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">>></a>
        <?php else: ?>
            <span style="color: grey">Сюда&gt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">>>&gt;</span>
        <?php endif; ?>
        &nbsp;&nbsp;&nbsp;
    <?php endif; ?>       
</div>

<?php include __DIR__ . '/footer.php'; ?>


