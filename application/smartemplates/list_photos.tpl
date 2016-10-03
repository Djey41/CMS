{include file='file:./admin_header.tpl'}
<a href="adminindex.php">&laquo; Назад</a><br />
<h2>Photographs</h2>

<strong class="error">{outputMessage($message)}</strong>
<table class="bordered">
    <tr>
        <th>Миниатюра</th>
        <th>Имя файла</th>
        <th>Название</th>
        <th>Размер</th>
        <th>Тип</th>
        <th>Тэг</th>
        <th>Просм.</th>
        <th>Загружен</th>
        <th>Коммент.</th>
        <th>Ред.</th>
        <th>Удал.</th>
    </tr>

    {foreach from=$photos item=photo}
    <tr>
        <td>
            <a href="./photo.php?id={$photo->id}">
            <img src="../../prewiev/{$photo->prew_name}" width="100" />
        </a>
        </td>
        <td>{$photo->filename}</td>
        <td>{$photo->caption}</td>
        <td>{$photo->sizeAsText()}</td>
        <td>{$photo->type}</td>
        <td>{$photo->alt}</td>
        <td>{$photo->views}</td>
        <td>{$photo->dt}</td>
        <td>
            <a href="comments.php?id={$photo->id}">
                {count($photo->forGettingOfNumberComments())}
            </a>
        </td>
        <td><a href="update_photoinfo.php?id={$photo->id}">Обновить</a></td>
        <td><a href="delete_photo.php?id={$photo->id}">Удалить</a></td>
    </tr>
    {/foreach}
</table>
<br />
<a href="photo_upload.php">Загрузить изображение</a>
<br /><br />
<div id="pagination" style="clear: both;">
    {if $pagination->totalPages() > 1}

        {if $pagination->hasPreviousPage()}
            <a href="list_photos.php?page={$pagination->previousPage()}">&laquo; Взад</a>
        {/if}
        {*assign var="total_pages" value=$pagination->total_pages()+1*}

        {*$total_pages*}{*$page*}

        {section name="i" start = 1 loop=$pagination->totalPages()+1 step=1}

            {if $smarty.section.i.index == $pagination->current_page}
                <span class="selected">{$smarty.section.i.index}</span>
            {else}
                <a href="list_photos.php?page={$smarty.section.i.index}">{$smarty.section.i.index}</a>
            {/if}
        {/section}

        {if $pagination->hasNextPage()}
            <a href="list_photos.php?page={$pagination->nextPage()}">Вперед &raquo;</a>
        {/if}
        <form action="list_photos.php" method="GET">

            <input type="number" size="5" name="page" value="1" step="1" min="1"  max="{$pagination->totalPages()}"/>
            <button>&laquo;&raquo;</button>
            <!--input type="button" name="submit"  /-->
        </form>
    {/if}

</div>

{include file='file:./admin_footer.tpl'}