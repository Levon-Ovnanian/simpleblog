        <td colspan="3" class="sidebar">
        <div class="sidebarHeader"></div>
            <ul>
                <li><a href="/">Главная страница</a></li>
                <?php if (!empty($user)) : ?>
                    <li><a href="/articles/add">Создать статью</a></li>
                    <li><a href="/adminpanel">Админка</a></li>
                    <li><a href="/users/manager/date/DESC">Менеджер пользователей</a></li>
                <?php endif; ?>
            </ul>    
    </body>
</html>
