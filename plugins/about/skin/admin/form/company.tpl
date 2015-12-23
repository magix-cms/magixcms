<form action="{$smarty.server.REQUEST_URI}" id="info_company_form" method="post" class="form-horizontal forms_plugins_informations">
    <fieldset>
        <legend>{#company_legend#|ucfirst}</legend>
        <div class="form-group">
            <label for="company_name" class="col-sm-2 control-label">{#company_name#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_name" name="company_name" {if $companyData.name}value="{$companyData.name}" {/if}placeholder="{#company_name_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="company_desc" class="col-sm-2 control-label">{#company_desc#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_desc" name="company_desc" {if $companyData.desc}value="{$companyData.desc}" {/if}placeholder="{#company_desc_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="company_slogan" class="col-sm-2 control-label">{#company_slogan#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_slogan" name="company_slogan" {if $companyData.slogan}value="{$companyData.slogan}" {/if}placeholder="{#company_slogan_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="company_type" class="col-sm-2 control-label">{#company_type#|ucfirst}</label>
            <div class="col-sm-10">
                <select name="company_type" id="company_type" class="form-control">
                    <option value selected disabled>-- {#company_type_ph#|ucfirst} --</option>
                    {foreach $schemaTypes as $val => $type}
                        <option value="{$val}"{if $companyData.type == $val} selected{/if}>{$type.label}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="company_tva" class="col-sm-2 control-label">{#company_tva#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_tva" name="company_tva" {if $companyData.tva}value="{$companyData.tva}" {/if}placeholder="{#company_tva_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="eshop" class="col-sm-2 control-label toggle-label">
                {#company_eshop#|ucfirst}
            </label>
            <div class="col-sm-2">
                <div class="checkbox" for="eshop">
                    <label>
                        <input{if $companyData.eshop} checked{/if} id="eshop" name="eshop" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="primary" data-offstyle="default" >
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">{#save#|ucfirst}</button>
            </div>
        </div>
    </fieldset>
</form>