<h3>{#concat#}</h3>
<div class="mc-info clearfix">
    <div class="col-sm-10 alert alert-info">
        <span class="fa fa-info-sign"></span> {#p_concatenating#}
    </div>
</div>
<form id="forms_config_concat" class="form-inline" method="post" action="">
    <label class="radio-inline">
        <input type="radio" name="concat" id="concat" value="0"{if $concat eq 0} checked="checked"{/if} />
        {#deactivate#}
    </label>
    <label class="radio-inline">
        <input type="radio" name="concat" id="concat_1" value="1"{if $concat eq 1} checked="checked"{/if} />
        {#activate#}
    </label>
    <input type="submit" class="btn btn-primary" value="Envoyer" />
</form>
<h3>{#type_cache#}</h3>
<div class="mc-info clearfix">
    <div class="col-sm-10 alert alert-info">
        <span class="fa fa-info-sign"></span> {#alert_info_cache_type#}
    </div>
</div>
<div class="mc-info clearfix">
    <div class="col-sm-10 alert alert-warn">
        <span class="fa fa-warning-sign"></span> {#alert_warn_cache_type#}
    </div>
</div>
<form id="forms_config_cache" class="form-inline" method="post" action="">
    <div class="form-group">
        {$select_concat}
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>