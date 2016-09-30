{include file='file:./admin_header.tpl'}
<a href="adminindex.php">&laquo; Назад</a><br />
<h2>Display Settings</h2>

<div id="comment-form">
    <h3>Adding Parameters</h3>
    <strong class="error">{outputMessage($message)}</strong>
    <form action="display_settings.php" method="POST">
        <table>
            <tr>
                <td><label for="width-field">Ширина фона:</label></td>
                <td><input id="width-field" type="number" name="width" value="{$params->width}" /></td>
            </tr>
            <tr>
                <td><label for="height-field">Высота фона:</label></td>
                <td><input id="height-field" type="number" name="height" value="{$params->height}" /></td>
            </tr>
            <tr>
                <td><label for="color-field">Цвет фона (англ.):</label></td>
                <td><input id="color-field" type="text" name="rgb" value="{$params->rgb}" /></td>
            </tr>
            <tr>
                <td><label for="qual-field">Качество изображения (max-100):</label></td>
                <td><input id="qual-field" type="number" name="quality" value="{$params->quality}" /></td>
            </tr>
            <tr>
                <td><label for="title-field">Изменить титул старницы:</label></td>
                <td><input id="title-field" type="text" name="title" value="{$params->title}" /></td>
            </tr>
            <tr>
                <td><label for="footer-field">Изменить заголовок:</label></td>
                <td><input id="footer-field" type="text" name="footer" value="{$params->footer}" /></td>
            </tr>
            <tr>
                <td><label for="npages">Изменить имя старницы:</label></td>
                <td><input id="npages" type="text" name="name_pages" value="{$params->name_pages}" /></td>
            </tr>
            <tr>
                <td><label for="count">Количество изображений на странице:</label></td>
                <td><input id="count" type="number" name="count_images" value="{$params->count_images}" /></td>
            </tr>
            <tr>
                <td><label for="sort">Сортировка по изображениям:</label></td>
                <td><input id="sort" type="radio" checked name="sort" value="views" /></td>
            </tr>
            <tr>
                <td><label for="sort2">Сортировка по комментариям:</label></td>
                <td><input id="sort2" type="radio" name="sort" value="comments" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit Settings" /></td>
            </tr>
        </table>
    </form>
</div>
{include file='file:./admin_footer.tpl'}
