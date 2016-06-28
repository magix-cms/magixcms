{if !isset($classCol)}
    {$classCol = "col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right"}
{/if}
<section id="map">
    <p class="lead">{#info_contact#|ucfirst}</p>
    {if $companyData.contact.mail}
    <p class="email">
        <span class="fa fa-envelope"></span>
        {if $companyData.contact.click_to_mail}
            {mailto address={$companyData.contact.mail} encode="hex"}
        {else}
            {if $companyData.contact.crypt_mail}
                {*{$companyData.contact.mail|replace:'@':'[at]'}*}
                {$companyData.contact.mail|replace:'@':'<span class="fa fa-at"></span>'}
            {else}
                {$companyData.contact.mail}
            {/if}
        {/if}
    </p>
    {/if}
    <div>
        {if $companyData.contact.phone}
        <p><span class="fa fa-phone"></span>{if $companyData.contact.click_to_call}<a href="tel:{$companyData.contact.phone|replace:'(0)':''|replace:' ':''|replace:'.':''}">{/if}{$companyData.contact.phone}{if $companyData.contact.click_to_call}</a>{/if}</p>
        {/if}
        {if $companyData.contact.mobile}
        <p><span class="fa fa-mobile"></span>{if $companyData.contact.click_to_call}<a href="tel:{$companyData.contact.mobile|replace:'(0)':''|replace:' ':''|replace:'.':''}">{/if}{$companyData.contact.mobile}{if $companyData.contact.click_to_call}</a>{/if}</p>
        {/if}
        {if $companyData.contact.fax}
            <p><span class="fa fa-fax"></span>{$companyData.contact.fax}</p>
        {/if}
        {if $companyData.contact.adress.street}
        <p itemscope itemtype="http://schema.org/PostalAddress" class="adresse">
            <span class="fa fa-map-marker"></span> {$companyData.contact.adress.adress}
        </p>
        {/if}
    </div>
    {if $companyData.openinghours}
    <div class="schedule">
        {include file="section/brick/openinghours.tpl"}
    </div>
    {/if}
    {*<h3 class="title-block">{#plan_acces#|ucfirst}</h3>
    <a href="{geturl}/{getlang}/gmap/" title="{#plan_acces#|ucfirst}">
        <img src="/skin/{template}/img/map.jpg" title="{#plan_acces#|ucfirst}" alt="{#plan_acces#|ucfirst}" class="img-responsive" width="480" height="360"/>
    </a>*}
</section>