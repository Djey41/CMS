{include file='file:./admin_header.tpl'}
<a href="./login.php">&laquo; Back</a><br />
<strong class="error">{outputMessage($message)}</strong>
<br>
<form action="registration.php" method="post">
    <table>
        <tr>
            <td><label for="uname-field">*Ваш логин(2-20):</label></td>
            <td><input placeholder="login" type="text" name="username" value="{$username}" id="uname-field"></td>
        </tr>
        <tr>
            <td><label for="pass-field">*Ваш пароль(мин. 8):</label></td>
            <td><input placeholder="your password" type="password" name="password"  id="pass-field"></td>
        </tr>
        <tr>
            <td><label for="pass2-field">*Повторите пароль:</label></td>
            <td><input placeholder="repeat your password" type="password" name="password2"  id="pass2-field"></td>
        </tr>
        <tr>
            <td><label for="fname-field">Имя:</label></td>
            <td><input placeholder="first name" type="text" name="first_name" value="{$reg->first_name}" id="fname-field"></td>
        </tr>
        <tr>
            <td><label for="lname-field">Фамилия:</label></td>
            <td><input placeholder="last name" type="text" name="last_name" value="{$reg->last_name}" id="lname-field"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Registration"></td>
        </tr>
    </table>
</form>

{include file='file:./admin_footer.tpl'}