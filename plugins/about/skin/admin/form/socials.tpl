<form action="{$smarty.server.REQUEST_URI}" id="info_socials_form" method="post" class="form-horizontal forms_plugins_informations">
    <fieldset>
        <legend>{#socials_legend#|ucfirst}</legend>
        <div class="form-group">
            <label for="social_facebook" class="col-sm-2 control-label">{#socials_facebook#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_facebook" name="company_socials[facebook]" {if $companyData.socials.facebook}value="{$companyData.socials.facebook}" {/if}placeholder="{#socials_facebook_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="social_twitter" class="col-sm-2 control-label">{#socials_twitter#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_twitter" name="company_socials[twitter]" {if $companyData.socials.twitter}value="{$companyData.socials.twitter}" {/if}placeholder="{#socials_twitter_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="social_google" class="col-sm-2 control-label">{#socials_google#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_google" name="company_socials[google]" {if $companyData.socials.google}value="{$companyData.socials.google}" {/if}placeholder="{#socials_google_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="social_linkedin" class="col-sm-2 control-label">{#socials_linkedin#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_linkedin" name="company_socials[linkedin]" {if $companyData.socials.linkedin}value="{$companyData.socials.linkedin}" {/if}placeholder="{#socials_linkedin_ph#|ucfirst}">
            </div>
        </div>
        <div class="form-group">
            <label for="social_viadeo" class="col-sm-2 control-label">{#socials_viadeo#|ucfirst}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="social_viadeo" name="company_socials[viadeo]" {if $companyData.socials.viadeo}value="{$companyData.socials.viadeo}" {/if}placeholder="{#socials_viadeo_ph#|ucfirst}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">{#save#|ucfirst}</button>
            </div>
        </div>
    </fieldset>
</form>