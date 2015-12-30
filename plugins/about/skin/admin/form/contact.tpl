<form action="{$smarty.server.REQUEST_URI}" id="info_contact_form" method="post" class="form-horizontal forms_plugins_informations">
    <fieldset>
        <legend>{#contact_legend#|ucfirst}</legend>
        <div class="form-group">
            <label for="company_mail" class="col-sm-2 control-label">{#contact_mail#|ucfirst} <span class="fa fa-envelope"></span></label>
            <div class="col-sm-7">
                <input type="email" class="form-control" id="company_mail" name="company_mail" {if $companyData.contact.mail}value="{$companyData.contact.mail}" {/if}placeholder="{#contact_mail_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="click_to_mail" class="col-sm-2 control-label toggle-label">
                {#contact_click#|ucfirst}
                <a href="#" class="text-info" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="{#contact_click_ph#|ucfirst}">
                    <span class="fa fa-question-circle"></span>
                </a>
            </label>
            <div class="col-sm-2">
                <div class="checkbox">
                    <label>
                        <input{if $companyData.contact.click_to_mail} checked{/if} id="click_to_mail" name="click_to_mail" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="primary" data-offstyle="default" >
                    </label>
                </div>
            </div>
            <label for="crypt_mail" class="col-sm-3 control-label toggle-label">
                {#contact_crypt#|ucfirst} {#contact_recommended#|ucfirst}
                <a href="#" class="text-info" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="{#contact_crypt_ph#|ucfirst}">
                    <span class="fa fa-question-circle"></span>
                </a>
            </label>
            <div class="col-sm-2">
                <div class="checkbox">
                    <label>
                        <input{if $companyData.contact.crypt_mail} checked{/if} id="crypt_mail" name="crypt_mail" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="primary" data-offstyle="default" >
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="company_phone" class="col-sm-2 control-label">{#contact_phone#|ucfirst} <span class="fa fa-phone"></span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_phone" name="company_phone" {if $companyData.contact.phone}value="{$companyData.contact.phone}" {/if}placeholder="{#contact_phone_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="company_mobile" class="col-sm-2 control-label">{#contact_mobile#|ucfirst} <span class="fa fa-mobile"></span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_mobile" name="company_mobile" {if $companyData.contact.mobile}value="{$companyData.contact.mobile}" {/if}placeholder="{#contact_mobile_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="click_to_call" class="col-sm-2 control-label toggle-label">
                {#contact_call#|ucfirst}
                <a href="#" class="text-info" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="{#contact_call_ph#|ucfirst}">
                    <span class="fa fa-question-circle"></span>
                </a>
            </label>
            <div class="col-sm-2">
                <div class="checkbox">
                    <label>
                        <input{if $companyData.contact.click_to_call} checked{/if} id="click_to_call" name="click_to_call" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="primary" data-offstyle="default" >
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="company_fax" class="col-sm-2 control-label">{#contact_fax#|ucfirst} <span class="fa fa-fax"></span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="company_fax" name="company_fax" {if $companyData.contact.fax}value="{$companyData.contact.fax}" {/if}placeholder="{#contact_fax_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="company_adress" class="col-sm-2 control-label">{#contact_adress#|ucfirst} <span class="fa fa-map-marker"></span></label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="company_adress">{#contact_street#|ucfirst}</label>
                        <input id="company_adress" type="text" name="company_adress[street]" {if $companyData.contact.adress.street}value="{$companyData.contact.adress.street}" {/if}placeholder="{#contact_street_ph#|ucfirst}" class="form-control" />
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <label for="company_postcode">{#contact_postcode#|ucfirst}</label>
                        <input id="company_postcode" type="text" name="company_adress[postcode]" {if $companyData.contact.adress.postcode}value="{$companyData.contact.adress.postcode}" {/if}placeholder="{#contact_postcode_ph#|ucfirst}" class="form-control" />
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <label for="company_city">{#contact_city#|ucfirst}</label>
                        <input id="company_city" type="text" name="company_adress[city]" {if $companyData.contact.adress.city}value="{$companyData.contact.adress.city}" {/if}placeholder="{#contact_city_ph#|ucfirst}" class="form-control" />
                    </div>
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
<form action="{$smarty.server.REQUEST_URI}" id="info_language_form" method="post" class="form-horizontal forms_plugins_informations">
    <fieldset>
        <legend>{#lang_legend#|ucfirst}</legend>
        <p>{$companyData.contact.languages}</p>
        <div class="form-group">
            <div class="col-sm-10">
                <button type="submit" name="refesh_lang" value="refresh" class="btn btn-primary">{#refresh#|ucfirst}</button>
            </div>
        </div>
    </fieldset>
</form>