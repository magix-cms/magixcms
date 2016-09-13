<form id="forms_config_cssinliner" class="form-inline" method="post" action="">
    <div class="checkbox">
        <label>
            <input id="css_inliner" data-toggle="toggle" type="checkbox" name="css_inliner" data-on="oui" data-off="non"{if $css_inliner} checked{/if}>
        </label>
    </div>
    <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}" />
</form>