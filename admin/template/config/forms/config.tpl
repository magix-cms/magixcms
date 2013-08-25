<form id="forms_config_edit" method="post" class="form-inline" action="">
{foreach $array_radio_config as $key => $value nocache}
    {*{if $value@iteration % 2 == 0 && $value@iteration > 0}
        </div>
        <div class="row-fluid">
    {/if}*}
    {if $value@first}
        <div class="form-group">
        <div class="col-lg-12">
    {elseif ($value@iteration - 1) is div by 2}
        </div>
        </div>
        <div class="form-group">
        <div class="col-lg-12">
    {/if}
        <h3>
            {#$key#|ucfirst}
        </h3>
        <label class="radio-inline">
            <input type="radio" name="{$key}" id="{$key}" value="0"{if $value eq 0} checked="checked"{/if} />
            {#off#|ucfirst}
        </label>
        <label class="radio-inline">
            <input type="radio" name="{$key}" id="{$key}_{$value@iteration}" value="1"{if $value eq 1} checked="checked"{/if} />
            {#on#|ucfirst}
        </label>
    {if $value@last}
        </div>
        </div>
    {/if}
{/foreach}
    <p class="input-btn">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </p>
</form>