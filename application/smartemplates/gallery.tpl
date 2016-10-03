{include file="./header.tpl"}


{foreach from=$photos item=photo}

<div style="float: left; margin-left: 20px;">
    <a href="photo.php?id={$photo->id}"> {* обращаемся через объект к его свойству или методу*}
        <img src="../../prewiev/{$photo->prew_name}" />
    </a>
    <p>{$photo->caption}<br>&nbsp;комм: {count($photo->forGettingOfNumberComments())}<br> просм: {$photo->views}</p>
</div>
{/foreach}

<div id="pagination" style="clear: both;">
    {if $pagination->totalPages() > 1}

        {if $pagination->hasPreviousPage()}
        <a href="gallery.php?page={$pagination->previousPage()}">&laquo; Взад</a>
        {/if}
        {*assign var="total_pages" value=$pagination->total_pages()+1*}

        {*$total_pages*}{*$page*}

  {section name="i" start = 1 loop=$pagination->totalPages()+1 step=1}

        {if $smarty.section.i.index == $pagination->current_page}
            <span class="selected">{$smarty.section.i.index}</span>
        {else}
            <a href="gallery.php?page={$smarty.section.i.index}">{$smarty.section.i.index}</a>
        {/if}
  {/section}

    {if $pagination->hasNextPage()}
    <a href="gallery.php?page={$pagination->nextPage()}">Вперед &raquo;</a>
    {/if}
        <form action="gallery.php" method="GET">

            <input type="number" size="5" name="page" value="1" step="1" min="1"  max="{$pagination->totalPages()}"/>
            <button>&laquo;&raquo;</button>
            <!--input type="button" name="submit"  /-->
        </form>
  {/if}

</div>

{include file="./footer.tpl"}