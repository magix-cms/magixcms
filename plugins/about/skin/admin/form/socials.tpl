{*<h2>{#info_socials#|ucfirst}</h2>*}
<form action="{$smarty.server.REQUEST_URI}" id="info_socials_form" method="post" class="form-horizontal forms_plugins_informations">
    <fieldset>
        <legend>Liens vers les pages des réseaux sociaux pour votre entreprise</legend>
        <div class="form-group">
            <label for="social_facebook" class="col-sm-2 control-label">Facebook</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_facebook" name="company_socials[facebook]" {if $companyData.socials.facebook}value="{$companyData.socials.facebook}" {/if}placeholder="Lien vers la page Facebook de votre entreprise">
            </div>
        </div>
        <div class="form-group">
            <label for="social_twitter" class="col-sm-2 control-label">Twitter</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_twitter" name="company_socials[twitter]" {if $companyData.socials.twitter}value="{$companyData.socials.twitter}" {/if}placeholder="Lien vers la page Twitter de votre entreprise">
            </div>
        </div>
        <div class="form-group">
            <label for="social_google" class="col-sm-2 control-label">Google+</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_google" name="company_socials[google]" {if $companyData.socials.google}value="{$companyData.socials.google}" {/if}placeholder="Lien vers la page Google de votre entreprise">
            </div>
        </div>
        <div class="form-group">
            <label for="social_linkedin" class="col-sm-2 control-label">LinkedIn</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_linkedin" name="company_socials[linkedin]" {if $companyData.socials.linkedin}value="{$companyData.socials.linkedin}" {/if}placeholder="Lien vers la page LinkedIn de votre entreprise">
            </div>
        </div>
        <div class="form-group">
            <label for="social_viadeo" class="col-sm-2 control-label">Viadeo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_viadeo" name="company_socials[viadeo]" {if $companyData.socials.viadeo}value="{$companyData.socials.viadeo}" {/if}placeholder="Lien vers la page Viadeo de votre entreprise">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </fieldset>
</form>