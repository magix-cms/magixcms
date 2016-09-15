<h2>
    Configuration
</h2>
<form id="forms_cssinliner_config" class="form-inline" method="post" action="">
    <div class="checkbox">
        <label>
            <input id="css_inliner" data-toggle="toggle" type="checkbox" name="css_inliner" data-on="oui" data-off="non"{if $css_inliner} checked{/if}>
        </label>
    </div>
    <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}" />
</form>
<h2>
    Définition des couleurs
</h2>
<form id="forms_cssinliner_color" method="post" action="">
    <h3>
        Header
    </h3>
    <div class="row">
        <div class="form-group col-md-4">
            <label>
                Background
            </label>
            <div class="input-group colorpicker-component csspicker">
                <input type="text" value="{$data[0].color_cssi}" class="form-control" name="color[]" />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>
                Color
            </label>
            <div class="input-group colorpicker-component csspicker">
                <input type="text" value="{$data[1].color_cssi}" class="form-control" name="color[]" />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
    </div>
    <h3>
        Footer
    </h3>
    <div class="row">
        <div class="form-group col-md-4">
            <label>
                Background
            </label>
            <div class="input-group colorpicker-component csspicker">
                <input type="text" value="{$data[2].color_cssi}" class="form-control" name="color[]" />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>
                Color
            </label>
            <div class="input-group colorpicker-component csspicker">
                <input type="text" value="{$data[3].color_cssi}" class="form-control" name="color[]" />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}" />
</form>