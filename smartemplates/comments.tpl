{include file='file:./admin_header.tpl'}
<a href="list_photos.php">&laquo; Back</a><br />
<br />

<h2>Комментарии к изображению: {$photo->filename}</h2>

{outputMessage($message)}
<div id="comments">
    {foreach from=$comments item=comment}
    <div class="comment" style="margin-bottom: 2em;">
        <div class="author">
            {htmlentities($comment->author)} wrote:
        </div>
        <div class="body">
            {strip_tags($comment->body, '<strong><em><p>')}
        </div>
        <div class="meta-info" style="font-size: 0.8em;">
            {datetimeToText($comment->created)}
        </div>
        <div class="actions" style="font-size: 0.8em;">
            <a href="delete_comment.php?id={$comment->id}">Delete Comment</a>
        </div>
    </div>
    {/foreach}
  {if empty($comments)} No Comments. {/if}
</div>

<div id="pagination" style="clear: both;">
    {if $pagination->totalPages() > 1}

        {if $pagination->hasPreviousPage()}
            <a href="comments.php?page={$pagination->previousPage()}">&laquo; Previous</a>
        {/if}
        {*assign var="total_pages" value=$pagination->total_pages()+1*}

        {*$total_pages*}{*$page*}

        {section name="i" start = 1 loop=$pagination->totalPages()+1 step=1}

            {if $smarty.section.i.index == $pagination->current_page}
                <span class="selected">{$smarty.section.i.index}</span>
            {else}
                <a href="comments.php?page={$smarty.section.i.index}">{$smarty.section.i.index}</a>
            {/if}
        {/section}
    {*$pagination->has_next_page()*}
        {if $pagination->hasNextPage()}
            <a href="comments.php?page={$pagination->nextPage()}">Next &raquo;</a>
        {/if}
        <form action="comments.php" method="GET">

            <input type="number" size="5" name="page" value="1" step="1" min="1"  max="{$pagination->totalPages()}"/>
            <button>&laquo;&raquo;</button>
            <!--input type="button" name="submit"  /-->
        </form>
    {/if}

</div>

{include file='file:./admin_footer.tpl'}