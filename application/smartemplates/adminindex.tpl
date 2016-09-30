{include file='file:./admin_header.tpl'}{* не работал ни с абсолютным путём ни без указания на текущую папку *}

<h2>Меню</h2>

<strong class="error">{outputMessage($message)}</strong>
<ul>
    <li><a href="./list_photos.php">Список изображений</a></li>
    <li><a href="./logfile.php?path_log=log.txt">Авторизации</a></li>
    <li><a href="./logfile.php?path_log=errors_log.txt">Логи ошибок</a></li>
    <li><a href="./logout.php">Выход</a></li>
    <li><a href="./display_settings.php">Изменить отображение</a></li>
    <li><a href="./chang_pass.php">Сменить пароль</a></li>
    <li><a href="./mail_settings.php">Почтовые установки</a></li>
</ul>

{include file="./admin_footer.tpl"}