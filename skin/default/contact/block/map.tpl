{if !isset($classCol)}
    {$classCol = "col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right"}
{/if}
<section id="map">
    <p class="lead">{#info_contact#|ucfirst}</p>
    {if {#contact_mail#}}
    <p>
        <span class="fa fa-envelope"></span>
        {if {#click_to_mail#}}
            {mailto address={#contact_mail#} encode="hex"}
        {else}
            {#contact_mail#|replace:'@':'[at]'}
        {/if}
    </p>
    {/if}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {if {#contact_phone#}}
            <p><span class="fa fa-phone"></span>{#contact_phone#}</p>
            {/if}
            {if {#contact_fax#}}
                <p><span class="fa fa-fax"></span>{#contact_fax#}</p>
            {/if}
            {if {#contact_adress#}}
            <p class="adresse"><span class="fa fa-map-marker"></span>{#contact_adress#|ucfirst}</p>
            {/if}
        </div>
        {*<div class="col-xs-6 col-sm-12 col-md-12 col-lg-6 text-center schedule">
            <p><span class="fa fa-clock-o"></span></p>
            <p>{#opening_week#|ucfirst}</p>
            <p>{#opening_weekend#|ucfirst}</p>
        </div>*}
    </div>
    {*<h3 class="title-block">{#plan_acces#|ucfirst}</h3>
    <a href="{geturl}/{getlang}/gmap/" title="{#plan_acces#|ucfirst}"><img src="/skin/{template}/img/map.jpg" title="{#plan_acces#|ucfirst}" alt="{#plan_acces#|ucfirst}" class="img-responsive" width="480" height="360"/></a>*}
</section>