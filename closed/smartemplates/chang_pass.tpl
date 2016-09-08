{include file='file:./admin_header.tpl'}
<a href="./adminindex.php">&laquo; Back</a><br />
{outputMessage($message)}
<form action="chang_pass.php" method="post">
    <table>
        <tr>
            <td><label for="uname-field">New username:</label></td>
            <td><input placeholder="login" type="text" name="username" value="{$username}" id="uname-field"></td>
        </tr>
        <tr>
            <td><label for="pass-field">Your password:</label></td>
            <td><input placeholder="old password" type="password" name="old_password"  id="pass-field"></td>
        </tr>
        <tr>
            <td><label for="passnew-field">New password:</label></td>
            <td><input placeholder="new password" type="password" name="new_password"  id="passnew-field"></td>
        </tr>
        <tr>
            <td><label for="pass2-field">Repeat new password:</label></td>
            <td><input placeholder="repeat new password" type="password" name="new_password2"  id="pass2-field"></td>
        </tr>
        <tr>
            <td><label for="fname-field">New first name:</label></td>
            <td><input placeholder="first name" type="text" name="first_name" value="{$chang->first_name}" id="fname-field"></td>
        </tr>
        <tr>
            <td><label for="lname-field">New last name:</label></td>
            <td><input placeholder="last name" type="text" name="last_name" value="{$chang->last_name}" id="lname-field"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Change date"></td>
        </tr>
    </table>
</form>

{include file='file:./admin_footer.tpl'}