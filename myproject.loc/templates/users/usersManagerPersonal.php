<?php include __DIR__ . '/../users/headerForUsersManager.php'; ?>


<tr>    
    <td style="border: 2px black solid;">       
        <img src="http://176.36.123.219/uploads/profile_images/<?= $userManaged->getIconPath(); ?>" height="80px" id= "<?= $userManaged->getId(); ?>"> 
        <a href="/user/<?= $userManaged->getId();?>"><h3><?= $userManaged->getNickName(); ?></h3></a>
        <?php if (isset($formOptionData[6]) AND $formOptionData[6] === $userManaged->getId()): ?>            
            <p>Роль:</p>
            <form action="/users/edit/personal/<?= $userManaged->getId(); ?>" method="post">
                <p><select size="1" name="role">
                    <?php if ($formOptionData[0] === 'admin'): ?>     
                        <option selected value ="admin">Администратор</option>
                        <option value = "user">Пользователь</option>
                    <?php elseif($formOptionData[0] === 'user'): ?>
                        <option selected value = "user">Пользователь</option>
                        <option value ="admin">Администратор</option>
                    <?php endif; ?>    
                </select></p>
                       
            <p>Статус:</p>             
            <form action="/users/edit/personal/<?= $userManaged->getId(); ?>" method="post">
                <p><select size="1" name="status" >
                    <?php if ($formOptionData[1] === 'active'): ?>     
                        <option selected value ="active">Активен</option>
                        <option value = "limited">Ограничен</option>
                        <option value ="blocked">Заблокирован</option>
                    <?php elseif($formOptionData[1] === 'limited'): ?>
                        <option value = "active">Активен</option>
                        <option selected value ="limited">Ограничен</option>
                        <option value ="blocked">Заблокирован</option>
                    <?php elseif($formOptionData[1] === 'blocked'): ?>
                        <option value = "active">Активен</option>
                        <option value ="limited">Ограничен</option>
                        <option selected value ="blocked">Заблокирован</option>
                    <?php endif; ?>
                </select></p>
                       
        <?php else: ?>
            <p>Роль:</p>
            <form action="/users/edit/personal/<?= $userManaged->getId(); ?>" method="post">
                <p><select size="1" name="role">
                <?php if ($userManaged->getRole() === 'admin'): ?>     
                    <option selected value ="admin">Администратор</option>
                    <option value = "user">Пользователь</option>
                <?php elseif($userManaged->getRole() === 'user'): ?>
                    <option selected value = "user">Пользователь</option>
                    <option value ="admin">Администратор</option>
                <?php endif; ?>    
                </select></p>
                  
            <p>Статус:</p>            
            <form action="/users/edit/personal/<?= $userManaged->getId(); ?>" method="post">
                <p><select size="1" name="status">
                <?php if ($userManaged->getStatus() === 'active'): ?>     
                    <option selected value ="active">Активен</option>
                    <option value = "limited">Ограничен</option>
                    <option value ="blocked">Заблокирован</option>
                <?php elseif($userManaged->getStatus() === 'limited'): ?>
                    <option value = "active">Активен</option>
                    <option selected value ="limited">Ограничен</option>
                    <option value ="blocked">Заблокирован</option>
                <?php elseif($userManaged->getStatus() === 'blocked'): ?>
                    <option value = "active">Активен</option>
                    <option value ="limited">Ограничен</option>
                    <option selected value ="blocked">Заблокирован</option>
                </select></p>
               
                <?php endif; ?>    
        <?php endif; ?>
    </td>
    <td>
        <p style="font-weight: bold;">Дата регистрации: <?= $userManaged->getCreatedAt(); ?></p>
        <p>Всего статей от автора: 
        <?php foreach($articlesCount[0] as $articleCount): ?>
            <?= $articleCount->count;?>
        <?php endforeach;?> </p>
        <p>Всего комментариев от автора: 
        <?php foreach($commentsCount[0] as $commentCount): ?>
            <?= $commentCount->count;?>
        <?php endforeach;?>   
        <hr> 
    </td>
</tr>  
<tr>
    <td colspan="3"> 
        <?php if (isset($formOptionData[6]) AND $formOptionData[6] === $userManaged->getId()): ?>        
            <p>Параметры уведомления:</p>
            <form action="/users/edit/personal/<?= $userManaged->getId(); ?>" method="post">
                <p>Получать уведомление о новой статье авторов:</p>      
                    <?php if ($formOptionData[2] === 1):?>
                        <input type="radio" id = "send" name="EmailSendIfArticle" value="1" checked>
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfArticle" value="0">
                        <label for="dontsend">Нет</label>
                    <?php else: ?>
                        <input type="radio" id = "send" name="EmailSendIfArticle" value="1">
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfArticle" value="0" checked>
                        <label for="dontsend">Нет</label>
                    <?php endif; ?> 
              
                    <p>Получать уведомление о новом комментарии:</p>
                    <?php if ($formOptionData[3] === 1): ?>
                        <input type="radio" id = "send" name="EmailSendIfComment" value="1" checked>
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfComment" value="0">
                        <label for="dontsend">Нет</label>
                    <?php else: ?>
                        <input type="radio" id = "send" name="EmailSendIfComment" value="1">
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfComment" value="0" checked>
                        <label for="dontsend">Нет</label>
                    <?php endif; ?> 
               
                    <p>Получать уведомление о новом фолловере:</p>
                    <?php if ($formOptionData[4] === 1): ?>
                        <input type="radio" id = "send" name="EmailSendIfAddFollower" value="1" checked>
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfAddFollower" value="0">
                        <label for="dontsend">Нет</label>
                    <?php else: ?>
                        <input type="radio" id = "send" name="EmailSendIfAddFollower" value="1">
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfAddFollower" value="0" checked>
                        <label for="dontsend">Нет</label>
                    <?php endif; ?>            
                      
                    <p>Получать уведомление об удалившемся фолловере:</p>
                    <?php if ($formOptionData[5] === 1): ?>
                        <input type="radio" id = "send" name="EmailSendIfDellFollower" value="1" checked>
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfDellFollower" value="0">
                        <label for="dontsend">Нет</label>
                    <?php else: ?>
                        <input type="radio" id = "send" name="EmailSendIfDellFollower" value="1">
                        <label for="send">Да</label>
                        <input type="radio" id = "dontsend" name="EmailSendIfDellFollower" value="0" checked>
                        <label for="dontsend">Нет</label>
                    <?php endif; ?>                  
        <?php else:?>
            <p>Параметры уведомления:</p>
            <form action="/users/edit/personal/<?= $userManaged->getId(); ?>" method="post">
                <p>Получать уведомление о новой статье авторов:</p>
                <?php if ($userManaged->getEmailSendIfArticle()):?>
                    <input type="radio" id = "send" name="EmailSendIfArticle" value="1" checked>
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfArticle" value="0">
                    <label for="dontsend">Нет</label>
                <?php else: ?>
                    <input type="radio" id = "send" name="EmailSendIfArticle" value="1" >
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfArticle" value="0" checked>
                    <label for="dontsend">Нет</label>
                <?php endif; ?> 
            
                <p>Получать уведомление о новом комментарии:</p>
                <?php if ($userManaged->getEmailSendIfComment()): ?>
                    <input type="radio" id = "send" name="EmailSendIfComment" value="1" checked>
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfComment" value="0">
                    <label for="dontsend">Нет</label>
                <?php else: ?>
                    <input type="radio" id = "send" name="EmailSendIfComment" value="1" >
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfComment" value="0" checked>
                    <label for="dontsend">Нет</label>
                <?php endif; ?> 
                
                <p>Получать уведомление о новом фолловере:</p>
                <?php if ($userManaged->getEmailSendIfAddFollower()): ?>
                    <input type="radio" id = "send" name="EmailSendIfAddFollower" value="1" checked>
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfAddFollower" value="0">
                    <label for="dontsend">Нет</label>
                <?php else: ?>
                    <input type="radio" id = "send" name="EmailSendIfAddFollower" value="1" >
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfAddFollower" value="0" checked>
                    <label for="dontsend">Нет</label>
                <?php endif; ?>            
              
                <p>Получать уведомление об удалившемся фолловере:</p>
                    <?php if ($userManaged->getEmailSendIfDellFollower()): ?>
                    <input type="radio" id = "send" name="EmailSendIfDellFollower" value="1" checked>
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfDellFollower" value="0">
                    <label for="dontsend">Нет</label>
                <?php else: ?>
                    <input type="radio" id = "send" name="EmailSendIfDellFollower" value="1">
                    <label for="send">Да</label>
                    <input type="radio" id = "dontsend" name="EmailSendIfDellFollower" value="0" checked>
                    <label for="dontsend">Нет</label>
                <?php endif; ?>                            
        <?php endif;?>
        <br>
    </td>                
</tr>
<tr>
    <td>
        <p>Фолловеры:</p>
        <p>Количество фолловеров: <?= count($followers[0]); ?></p>
        <?php if (!empty($followers[0])):?>
            <?php foreach($followers[0] as $follower):?>
                <img src="http://176.36.123.219/uploads/profile_images/<?= $follower->getIconPath(); ?>" height="40px">
                <p>Логин: <?= $follower->getNickName(); ?>
                <p>Почта: <?= $follower->getEmail(); ?>
                <br>
                <hr>
                <br>
            <?php endforeach;?>               
        <?php endif;?>
    </td>                            
    <td>
        <p>Подписки:</p>
        <p>Количество авторов: <?= count($subscribes[0]); ?></p>
        <?php if (!empty($subscribes[0])):?>
            <?php for ($x = 0; $x < count($subscribes[0]); $x++):?>
                <?php foreach($subscribes[0][$x] as $subscribe):?>
                    <img src="http://176.36.123.219/uploads/profile_images/<?= $subscribe->getIconPath(); ?>" height="40px">
                    <p>Логин: <?= $subscribe->getNickName(); ?>
                    <p>Почта: <?= $subscribe->getEmail(); ?>
                    <br>
                    <hr>
                    <br>
                <?php endforeach;?>
            <?php endfor;?>
        <?php endif;?>
    </td>
</tr>
</span>   
<tr>
    <td colspan="3" style="border:none;">  
        <div style="text-align:center"><input type="submit" value="Сохранить изменения"></input></div>
    </td>
</tr>
    </form>
    <br>    


