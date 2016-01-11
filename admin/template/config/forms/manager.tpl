<div class="mc-info clearfix">
    <p class="col-sm-10 alert alert-info">
        {#tinyMCE_version#} : <strong>{$smarty.const.VERSION_EDITOR}</strong>
    </p>
</div>
<h2>{#filemanager_editor#}</h2>
<form id="forms_editor_edit" method="post" class="form-inline" action="">
    <div class="form-group">
        {$select_manager}
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>
<h2>{#content_css_editor#}</h2>
<form id="forms_editor_css_edit" method="post" action="">
    <div class="form-group">
        <label for="content_css">{#link_css_editor#} :</label>
        <textarea class="form-control" id="content_css" name="content_css" cols="70" rows="3">{$content_css}</textarea>
    </div>
    <div class="mc-info clearfix">
        <p class="col-sm-10 alert alert-info">
            <span class="fa fa-info-sign"></span> {#info_css_editor#}:
            /skin/default/css/bootstrap/critical.min.css,/skin/default/css/bootstrap/bootstrap.min.css
        </p>
    </div>
    <p>
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </p>
</form>