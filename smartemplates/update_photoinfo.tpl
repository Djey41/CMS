{include file="./header.tpl"}
<a href="list_photos.php">&laquo; Back</a><br />
<br />

<div style="margin-left: 20px;">
    <img src="../../prewiev/{$photoup->prew_name}" />
    <p>{$photoup->caption}</p>
</div>


<div id="comment-form">
    <h3>New Parameters</h3>
    {*output_message($message)*}
    <form action="update_photoinfo.php?id={$photoup->id}" method="POST">
        <table>
            <tr>
                <td><label for="caption-field">New caption:</label></td>
                <td><input id="caption-field" type="text" name="caption" value="{$photoup->caption}" /></td>
            </tr>
            <tr>
                <td><label for="alt-field">New alt:</label></td>
                <td><input id="alt-field" type="text" name="alt" value="{$photoup->alt}" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Update params" /></td>
            </tr>
        </table>
    </form>
</div>
{include file="./footer.tpl"}