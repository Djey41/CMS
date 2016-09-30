{include file='file:./admin_header.tpl'}
<h2>Photo Upload</h2>

<a href="list_photos.php">&laquo; Назад</a><br />
<strong class="error">{outputMessage($message)}</strong>
<form action="photo_upload.php" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
    <p><input type="file" name="file_upload" /></p>
    <p><label>Название(буквы и цифры): <input type="text" name="caption" value="" /></label></p>
    <p><label>Тег alt(буквы и цифры): <input type="text" name="alt" value="" /></label></p>
    <input type="submit" name="submit" value="Upload" />
</form>
{include file='file:./admin_footer.tpl'}