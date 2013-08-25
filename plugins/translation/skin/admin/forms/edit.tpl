<form id="forms_plugins_translation" class="form-horizontal" method="post" action="">
{foreach $array_config_file as $key => $value nocache}
    <div class="form-group">
        <div class="col-sm-3">
            <input type="text" class="form-control" name="config_var[]" value="{$key}" readonly="readonly" size="50" />
        </div>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="config_value[]" value="{$value}" size="50" />
        </div>
    </div>
{/foreach}
    <p>
        <input type="submit" class="btn btn-primary" />
    </p>
</form>