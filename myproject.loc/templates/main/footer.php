                </td>
                
                <td class="sidebar">
                    <div class="sidebarHeader">Меню</div>
                    <ul>
                        <li><a href="/">Главная страница</a></li>
                        <?php if (!empty($user)) : ?>
                            <li><a href="/articles/add">Создать статью</a></li>
                            <?php if ($user->isAdmin()) : ?>
                                <li><a href="/adminpanel" style="color: red;">Стрaница администрaтора</a></li>
                                <li><a href="/users/manager/date/DESC" style="color: red;">Менеджер пользователей</a></li>
                            <?php endif; ?>        
                      <?php endif; ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="footer" colspan="2">Все права защищены (c) Simple blog
            </td>
            </tr>
        </table>
        
    </body>
</html>
