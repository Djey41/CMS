{include file="./header.tpl"}
<a href="{$path}">&laquo; Back</a><br />
<br />

<div style="margin-left: 20px;">
    <img src="{$photo->imagePath()}" />
    <p>{$photo->caption}</p>
</div>

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
    </div>
    {/foreach}
    {if empty($comments)}No Comments.{/if}
</div>

<div id="pagination" style="clear: both;">
    {if $pagination->totalPages() > 1}

        {if $pagination->hasPreviousPage()}
            <a href="photo.php?page={$pagination->previousPage()}">&laquo; Previous</a>
        {/if}
        {*assign var="total_pages" value=$pagination->total_pages()+1*}

        {*$total_pages*}{*$page*}

        {section name="i" start = 1 loop=$pagination->totalPages()+1 step=1}

            {if $smarty.section.i.index == $pagination->current_page}
                <span class="selected">{$smarty.section.i.index}</span>
            {else}
                <a href="photo.php?page={$smarty.section.i.index}">{$smarty.section.i.index}</a>
            {/if}
        {/section}
        {*$pagination->has_next_page()*}
        {if $pagination->hasNextPage()}
            <a href="photo.php?page={$pagination->nextPage()}">Next &raquo;</a>
        {/if}
        <form action="photo.php" method="GET">

            <input type="number" size="5" name="page" value="1" step="1" min="1"  max="{$pagination->totalPages()}"/>
            <button>&laquo;&raquo;</button>
            <!--input type="button" name="submit"  /-->
        </form>
    {/if}
</div>


<div id="comment-form">
    <h3>New Comment</h3>
    <strong class="error">{outputMessage($message)}</strong>
    <form action="photo.php?id={$photo->id}" method="post">
        <table>
            <tr>
                <td><label for="name-field">Ваше имя</label></td>
                <td><input id="name-field" type="text" name="author" value="{$author}" /></td>
            </tr>
            <tr>
                <td><label for="comm-field">Ваш комментарий:</label></td>
                <td><textarea id="comm-field" name="body" cols="40" rows="8">{$body}</textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit Comment" /></td>
            </tr>
        </table>
    </form>
</div>


{include file="./footer.tpl"}