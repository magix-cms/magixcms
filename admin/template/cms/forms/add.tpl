{if $smarty.get.get_page_p}
<form id="forms_cms_add_child" method="post" action="">
    <div class="form-group">
        <label for="title_page">{#page_name#|ucfirst} :</label>
        <input type="text" class="form-control" id="title_page" name="title_page" value="" size="50" />
    </div>
</form>
{else}
<form id="forms_cms_add_parent" method="post" action="">
    <div class="form-group">
        <label for="title_page">{#page_name#|ucfirst} :</label>
        <input type="text" class="form-control" id="title_page" name="title_page" value="" size="50" />
    </div>
</form>
{/if}