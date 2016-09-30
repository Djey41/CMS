{include file='file:./admin_header.tpl'}
<a href="./adminindex.php">&laquo; Назад</a><br />
<strong class="error">{outputMessage($message)}</strong>
<form action="mail_settings.php" method="post">
    <table>
        <tr>
            <td><label for="host-field">Хост:</label></td>
            <td><input placeholder="post's host" type="text" name="host" value="{$mail->host}" id="host-field"></td>
        </tr>
        <tr>
            <td><label for="mail-field">e-mail Откуда:</label></td>
            <td><input placeholder="e-mail from" type="email" name="mail_from"  value="{$mail->mail_from}"  id="mail-field"></td>
        </tr>
        <tr>
            <td><label for="pass-field">Пароль от почты Куда:</label></td>
            <td><input placeholder="Post password from" type="password" name="password"  id="pass-field"></td>
        </tr>
        <tr>
            <td><label for="port-field">Порт для соединения:</label></td>
            <td><input placeholder="Port to connect to" type="number" name="port"  id="port-field"></td>
        </tr>
        <tr>
            <td><label for="oname-field">Имя откуда:</label></td>
            <td><input placeholder="overall name from" type="text" name="overall_name" value="{$mail->overall_name}" id="oname-field"></td>
        </tr>
        <tr>
            <td><label for="mail2-field">e-mail Куда:</label></td>
            <td><input placeholder="E-mail for" type="email" name="mail_for" value="{$mail->mail_for}" id="mail2-field"></td>
        </tr>
        <tr>
            <td><label for="rec-field">Имя для ответа на письмо:</label></td>
            <td><input placeholder="add recipient" type="text" name="recipient" value="{$mail->recipient}" id="rec-field"></td>
        </tr>
        <tr>
            <td><label for="head-field">Тема письма:</label></td>
            <td><input placeholder="header" type="text" name="header" value="{$mail->header}" id="head-field"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Change mail's settings"></td>
        </tr>
    </table>
</form>

{include file='file:./admin_footer.tpl'}