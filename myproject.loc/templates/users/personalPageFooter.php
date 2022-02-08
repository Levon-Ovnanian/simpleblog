
                <td class="sidebar">
                    <div class="sidebarHeader">Меню</div>
                    <ul>
                        <li><a href="/">Главная страница</a></li>
                        <li><a href="/articles/add">Создать статью</a></li> 
                        <?php if ($user->isAdmin()): ?>
                            <li><a href="/adminpanel" style="color: red;">Стрaница администрaтора</a></li>     
                            <li><a href="/users/manager/date/DESC" style="color: red;">Менеджер пользователей</a></li>
                        <?php endif; ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="3" ><?php include __DIR__ . '/../users/pagePanel.php'; ?></td>
            </tr>
            <tr>
                <td class="footer" colspan="3">Все права защищены (c) Simple blog</td>
            </tr>
        </table>
    </body>
</html>
