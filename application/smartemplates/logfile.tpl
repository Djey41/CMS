{include file='file:./admin_header.tpl'}
<a href="adminindex.php">&laquo; Назад</a><br />
<br />

<h2>Log File</h2>

<strong class="error">{outputMessage($message)}</strong>
<p><a href="logfile.php?clear=true&path_log={$smarty.get.path_log}">Стереть логи</a><p>

    {if file_exists($logfile) && is_readable($logfile)}
			{if $handle = fopen($logfile, 'r')}
			{* это условие было в одном верхнем после && иф но Смарти не понимал
			присваивание в условии и давал ошибку на одиночный знак равно *}
            <ul class="log-entries">

             {while !feof($handle)}</br>
                {$entry = fgets($handle)}
                {if trim($entry) != ""}
                    <li>{$entry}</li>
                {/if}
            {/while}
            </ul>
            {* fclose($handle) *} {* Сей почему-то выводит единицу в тексте логов на новой строке необъяснимо!!! *}
            {/if}
    {else}
        Невозможно прочитать файл: {$logfile}
    {/if}

{include file='file:./admin_footer.tpl'}