{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
<section id="toolbar"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
    {if $adjust == 'clip'}
    <div class="container">
        <div class="row">
            {/if}
            {* Language Nav *}
            {widget_lang_data assign="dataLangNav"}
            <div class="pull-left lang-header">
                {include file="section/loop/lang.tpl" data=$dataLangNav type="nav"}
            </div>
            <div id="contact-infos" class="hidden-xs">
                <div class="text-right">
                    <ul class="pull-right">
                        {if {#contact_adress#}}
                            <li{if {#contact_fax#}} class="hidden-sm"{/if}><span class="fa fa-map-marker"></span>{#contact_adress#}</li>
                        {/if}
                        <li><a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}"><span class="fa fa-at"></span>{#contact_label#|ucfirst}</a></li>
                        {if {#contact_fax#}}
                            <li><span class="fa fa-fax"></span>{#contact_fax#}</li>
                        {/if}
                    </ul>
                </div>
            </div>
            {if {#contact_phone#}}
                <div class="visible-xs pull-right">
                    <ul>
                        <li><span class="fa fa-phone"></span>{#contact_phone#}</li>
                        <li class="toggle-menu"><a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}" class="navbar-toggle"><span class="fa fa-envelope"></span></a></li>
                    </ul>
                </div>
            {/if}
            {if $adjust == 'clip'}
        </div>
    </div>
    {/if}
</section>