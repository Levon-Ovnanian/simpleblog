<?php include __DIR__ . '/../users/headerForUsersManager.php'; ?>

<tr>
    <td colspan="3">
        <h4>Всего пользователей: <?php $users ?  print_r(count($users)) : print_r('0'); ?></h4>
        <?php if ($error): ?>
            <tr>
                <td style="color: red;"><?= $error;?></td>
            </tr>
            <tr>
                <td> 
                    <form action="/users/manager/<?= $filteredUserManager; ?>" method="post">
                        <p><select size="1" name="filteredUserManager">
                            <?php if ($filteredUserManager === 'date/DESC' || $filteredUserManager === null): ?>     
                                <option selected value="date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'date/ASC'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option selected value="date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'A-Z/DESC'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option selected value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'Z-A/ASC'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option selected value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'active'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option selected value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'limited'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option selected value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'blocked'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option selected value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'admin'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option selected value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'user'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option selected value= "user">Только пользователей</option>    
                            <?php endif; ?>            
                        </select></p>
                        <p><input type="submit" value="сортировать"></p>
                    </form>         
                </td>
            </tr> 
        <?php else:?>     
    </td>
            <tr>
                <td > 
                    <form action="/users/manager/<?= $filteredUserManager; ?>" method="post">
                        <p><select size="1" name="filteredUserManager">
                            <?php if ($filteredUserManager === 'date/DESC' || $filteredUserManager === null): ?>     
                                <option selected value="date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'date/ASC'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option selected value="date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'A-Z/DESC'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option selected value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'Z-A/ASC'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option selected value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'active'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option selected value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'limited'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option selected value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'blocked'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option selected value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif($filteredUserManager === 'admin'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option selected value= "admin">Только администраторов</option>
                                <option value= "user">Только пользователей</option>
                            <?php elseif ($filteredUserManager === 'user'): ?>
                                <option value= "date/DESC">По убыванию даты регистрации</option>
                                <option value= "date/ASC">По возрастанию даты регистрации</option>
                                <option value= "A-Z/DESC">Сортировать по алфавиту А-Я</option>
                                <option value= "Z-A/ASC">Сортировать по алфавиту Я-А</option>
                                <option value= "active">Только со статусом "Активен"</option>
                                <option value= "limited">Только со статусом "Ограничен"</option>
                                <option value= "blocked">Только со статусом "Заблокирован"</option>
                                <option value= "admin">Только администраторов</option>
                                <option selected value= "user">Только пользователей</option>    
                            <?php endif; ?>            
                        </select></p>
                        <p><input type="submit" value="сортировать"></p>
                    </form>         
                </td>
                <td>
                    <form action="/users/manager/<?= $filteredUserManager; ?>" method="post">    
                        <p>поиск пользователя<input type="text" name="filteredByUserNameUserManager"></p>
                        <p><input type="submit" value="найти"></p>
                    </form>                                
                </td>
            </tr>
</tr>
            <?php for ($i = 0; $i < count($users); $i++):?>
                <tr>    
                    <td style="border: 2px black solid;">       
                        <img src="http://176.36.123.219/uploads/profile_images/<?= $users[$i]->getIconPath(); ?>" height="80px" id= "<?= $users[$i]->getId(); ?>"> 
                        <a href="/users/edit/personal/<?= $users[$i]->getId();?>"><h3><?= $users[$i]->getNickName(); ?></h3></a>
                        <?php if ($users[$i]->getRole() === 'admin'): ?>
                            <p>Роль: Администратор</p>
                        <?php else: ?>
                            <p>Роль: Пользователь</p>
                        <?php endif; ?>    
                        <?php if ($users[$i]->getStatus() === 'active'): ?>
                            <p>Статус: Активен</p>
                        <?php elseif ($users[$i]->getStatus() === 'limited'): ?>
                            <p>Статус: Ограничен</p> 
                        <?php else: ?>   
                            <p>Статус: Заблокирован</p> 
                        <?php endif; ?>                    
                    </td>
                    <td>
                        <p style="font-weight: bold;">Дата регистрации: <?= $users[$i]->getCreatedAt(); ?></p>
                        <p>Всего статей от автора: 
                        <?php foreach($articlesCount[$i] as $articleCount): ?>
                            <?= $articleCount->count;?>
                        <?php endforeach;?> </p>
                        <p>Всего комментариев от автора: 
                        <?php foreach($commentsCount[$i] as $commentCount): ?>
                            <?= $commentCount->count;?>
                        <?php endforeach;?>   
                        <hr>
                        <?php if (!empty($followers[$i])):?>
                            <p>Количество фолловеров: <?= count($followers[$i]); ?></p>             
                        <?php else:?>
                            <p>Количество фолловеров: 0</p> 
                        <?php endif;?>    
                        <?php if (!empty($subscribes[$i])):?>
                            <p>Количество подписок: <?= count($subscribes[$i]); ?></p>
                        <?php else:?>
                            <p>Количество подписок: 0</p> 
                        <?php endif;?>        
                    </td>
                </tr>    
                <br>    
            <?php endfor;?>

    <?php endif;?>