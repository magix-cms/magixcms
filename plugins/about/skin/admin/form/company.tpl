{*<h2>{#info_company#|ucfirst}</h2>*}
<form action="{$smarty.server.REQUEST_URI}" id="info_company_form" method="post" class="form-horizontal forms_plugins_informations">
    <fieldset>
        <legend>Information concernant votre entreprise</legend>
        <div class="form-group">
            <label for="company_name" class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_name" name="company_name" {if $companyData.name}value="{$companyData.name}" {/if}placeholder="Nom de votre entreprise">
            </div>
        </div>
        <div class="form-group">
            <label for="company_type" class="col-sm-2 control-label">Type</label>
            <div class="col-sm-10">
                <select name="company_type" id="company_type" class="form-control">
                    <option value selected disabled>-- Choisissez un secteur d'activité --</option>
                    {foreach $schemaTypes as $val => $type}
                        <option value="{$val}"{if $companyData.type == $val} selected{/if}>{$type.label}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="company_tva" class="col-sm-2 control-label">N° de TVA</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_tva" name="company_tva" {if $companyData.tva}value="{$companyData.tva}" {/if}placeholder="Numéro de TVA de votre entrepise">
            </div>
        </div>
        <div class="form-group">
            <label for="eshop" class="col-sm-2 control-label toggle-label">
                Vente en ligne
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
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </fieldset>
</form>