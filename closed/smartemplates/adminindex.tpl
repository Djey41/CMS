{include file='file:./admin_header.tpl'}{* не работал ни с абсолютным путём ни без указания на текущую папку *}

<h2>Menu</h2>

{outputMessage($message)}
<ul>
    <li><a href="./list_photos.php">List Photos</a></li>
    <li><a href="./logfile.php?path_log=log.txt">View Log file</a></li>
    <li><a href="./logfile.php?path_log=errors_log.txt">View Log file Errors</a></li>
    <li><a href="./logout.php">Logout</a></li>
    <li><a href="./display_settings.php">Display's Settings</a></li>
    <li><a href="./chang_pass.php">Change Password</a></li>
    <li><a href="./mail_settings.php">Mail Settings</a></li>
</ul>

{include file="./admin_footer.tpl"}