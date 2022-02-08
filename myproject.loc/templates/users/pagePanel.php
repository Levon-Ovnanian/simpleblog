<div style="text-align: center">   
    <?php if ($lastPage < 6): ?>
        <?php if ($previousPageLink !== null): ?>
            <a href="/adminpanel/1/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><<</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $previousPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">&lt;Туда</a>     
            &nbsp;&nbsp;&nbsp;
        <?php else: ?>
            <span style="color: grey">&lt;&lt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">&lt;Туда</span>
            &nbsp;&nbsp;&nbsp;
        <?php endif; ?>

        <?php if ($lastPage === 1): ?>
            <a href="/adminpanel/<?= $currentPageNum; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum; ?></a>         
            
        <?php elseif ($lastPage === 2): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
            <?php endif; ?>

        <?php elseif ($lastPage === 3): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 3): ?>
                <a href="/adminpanel/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
            <?php endif; ?>     
            
        <?php elseif ($lastPage === 4): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 3; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
            <?php elseif ($currentPageNum === 3): ?>
                <a href="/adminpanel/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 4): ?>
                <a href="/adminpanel/<?= $currentPageNum - 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>   
            <?php endif; ?>

        <?php elseif ($lastPage === 5): ?>
            <?php if ($currentPageNum === 1): ?>
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 4; ?></a>
            <?php elseif ($currentPageNum === 2): ?>
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 3; ?></a>
            <?php elseif ($currentPageNum === 3): ?>
                <a href="/adminpanel/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 2; ?></a>
            <?php elseif ($currentPageNum === 4): ?>
                <a href="/adminpanel/<?= $currentPageNum - 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum + 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum + 1; ?></a>
            <?php elseif ($currentPageNum === 5): ?>
                <a href="/adminpanel/<?= $currentPageNum - 4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 4; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 2; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum - 1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum - 1; ?></a>
                &nbsp;&nbsp;&nbsp;
                <?= $currentPageNum; ?>          
            <?php endif; ?>    
        <?php endif; ?>

        <?php if ($nextPageLink !== null): ?>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $nextPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">Сюда&gt;</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $lastPage; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">>></a>
        <?php else: ?>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">Сюда&gt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">>>&gt;</span>
        <?php endif; ?>

    <?php else:?>
        <?php if ($previousPageLink !== null): ?>
            <a href="/adminpanel/1/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><<</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $previousPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">&lt;Туда</a>     
            &nbsp;&nbsp;&nbsp;
            <?php if ($currentPageNum >= 3 AND $currentPageNum !== $lastPage AND $currentPageNum !== $lastPage - 1): ?>
                <a href="/adminpanel/<?= $currentPageNum -2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -2; ?></a> 
                &nbsp;&nbsp;&nbsp;   
            <?php elseif ($currentPageNum === $lastPage): ?>
                <a href="/adminpanel/<?= $currentPageNum -4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -4; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum -3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum -2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -2; ?></a>
                &nbsp;&nbsp;&nbsp; 
            <?php elseif ($currentPageNum === $lastPage - 1): ?>
                <a href="/adminpanel/<?= $currentPageNum -3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -3; ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="/adminpanel/<?= $currentPageNum -2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -2; ?></a>
                &nbsp;&nbsp;&nbsp; 
            <?php endif; ?>  
                <a href="/adminpanel/<?= $currentPageNum -1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum -1; ?></a>
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
            <a href="/adminpanel/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
            <a href="/adminpanel/<?= $currentPageNum +2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +2; ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $currentPageNum +3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +3; ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $currentPageNum +4; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +4; ?></a>
            &nbsp;&nbsp;&nbsp;
        <?php elseif ($currentPageNum === 2): ?> 
            <a href="/adminpanel/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
            <a href="/adminpanel/<?= $currentPageNum +2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +2; ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $currentPageNum +3; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +3; ?></a>
            &nbsp;&nbsp;&nbsp;
        <?php elseif ($currentPageNum === $lastPage - 1): ?>
            <a href="/adminpanel/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
        <?php elseif ($currentPageNum !== $lastPage):?>
            <a href="/adminpanel/<?= $currentPageNum +1; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +1; ?></a>
            &nbsp;&nbsp;&nbsp; 
            <a href="/adminpanel/<?= $currentPageNum +2; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>"><?= $currentPageNum +2; ?></a>
            &nbsp;&nbsp;&nbsp;
        <?php endif; ?>
        
        <?php if ($nextPageLink !== null): ?>
            <a href="/adminpanel/<?= $nextPageLink ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">Сюда&gt;</a>
            &nbsp;&nbsp;&nbsp;
            <a href="/adminpanel/<?= $lastPage; ?>/<?= $orderBy; ?>/<?= $searchPanelName; ?>/<?= $searchPanelArgs; ?>">>></a>
        <?php else: ?>
            <span style="color: grey">Сюда&gt;</span>
            &nbsp;&nbsp;&nbsp;
            <span style="color: grey">>>&gt;</span>
        <?php endif; ?>
        &nbsp;&nbsp;&nbsp;
    <?php endif; ?>       
</div>
