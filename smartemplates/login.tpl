{include file='file:./admin_header.tpl'}
<a href="./registration.php">&laquo; Registration</a><br />
<h2>Staff Login</h2>
<p id="err">{outputMessage($message)}</p>
<form action="../../../closed/controllers/login.php" method="post">
    <table>
        <tr>
            <td><label for="us-field">Username:</label></td>
            <td>
                <input id="us-field" type="text" name="username" maxlength="30" value="{htmlentities($username)}" />
            </td>
        </tr>
        <tr>
            <td><label for="pass-field">Password:</label></td>
            <td>
                <input id="pass-field" type="password" name="password" maxlength="30" value="{htmlentities($password)}" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Login" />
            </td>
        </tr>
    </table>
</form>

{include file='file:./admin_footer.tpl'}
