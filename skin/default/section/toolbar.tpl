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
            {if $dataLangNav != null && count($dataLangNav) > 1}
                <div class="pull-left lang-header">
                    {include file="section/loop/lang.tpl" data=$dataLangNav type="nav"}
                </div>
            {elseif $companyData.socials != null}
                {if $companyData.socials.facebook != null || $companyData.socials.google != null || $companyData.socials.linkedin != null}
                    <div id="social-follow" class="pull-left">
                        <div class="text-left">
                            <ul>{if $companyData.socials.facebook != null}
                                    <li>
                                        <a itemprop="sameAs" href="{$companyData.socials.facebook}" title="{#fb_follow_title#|ucfirst}" role="link">
                                            <span class="fa fa-facebook"></span><span class="sr-only">{#fb_follow_label#|ucfirst}</span>
                                        </a>
                                    </li>
                                {/if}
                                {if $companyData.socials.twitter != null}
                                    <li>
                                        <a itemprop="sameAs" href="{$companyData.socials.twitter}" title="{#tw_follow_title#|ucfirst}" role="link">
                                            <span class="fa fa-twitter"></span><span class="sr-only">{#tw_follow_label#|ucfirst}</span>
                                        </a>
                                    </li>
                                {/if}
                                {if $companyData.socials.google != null}
                                    <li>
                                        <a itemprop="sameAs" href="{$companyData.socials.google}" title="{#gg_follow_title#|ucfirst}" role="link" rel="publisher">
                                            <span class="fa fa-google-plus"></span><span class="sr-only">{#gg_follow_label#|ucfirst}</span>
                                        </a>
                                    </li>
                                {/if}
                                {if $companyData.socials.linkedin != null}
                                    <li>
                                        <a itemprop="sameAs" href="{$companyData.socials.linkedin}" title="{#lk_follow_title#|ucfirst}" role="link">
                                            <span class="fa fa-linkedin"></span><span class="sr-only">{#lk_follow_label#|ucfirst}</span>
                                        </a>
                                    </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                {/if}
            {/if}
            <div id="contact-infos" class="hidden-xs">
                <div class="text-right">
                    <ul class="pull-right">
                        {if $companyData.contact.adress.street}
                            <li{if $companyData.contact.fax} class="hidden-sm"{/if} itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <span class="fa fa-map-marker"></span>
                                <span itemprop="streetAddress">{$companyData.contact.adress.street}</span>,
                                <span itemprop="postalCode">{$companyData.contact.adress.postcode}</span>
                                <span itemprop="addressLocality">{$companyData.contact.adress.city}</span>
                            </li>
                        {/if}
                        <li><a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}"><span class="fa fa-at"></span>{#contact_label#|ucfirst}</a></li>
                        {if $companyData.contact.fax}
                            <li>
                                <span class="fa fa-fax"></span>{$companyData.contact.fax}
                            </li>
                        {/if}
                        {if $companyData.contact.phone}
                            <li>
                                <span class="fa fa-phone"></span>{$companyData.contact.phone}
                            </li>
                        {/if}
                        {if $companyData.contact.mobile}
                            <li><span class="fa fa-mobile"></span>{$companyData.contact.mobile}</li>
                        {/if}

                        <div itemprop="contactPoint" itemscope itemtype="http://schema.org/ContactPoint">
                            {if $companyData.contact.mail}
                                <meta itemprop="email" content="{$companyData.contact.mail}"/>
                            {/if}
                            {if $companyData.contact.phone}
                                <meta itemprop="telephone" content="{$companyData.contact.phone}"/>
                            {else}
                                <meta itemprop="url" content="{geturl}/{getlang}/contact/"/>
                            {/if}
                            {if $companyData.contact.fax}
                                <meta itemprop="faxNumber" content="{$companyData.contact.fax}"/>
                            {/if}
                            <meta itemprop="contactType" content="customer support"/>
                            {$av_langs = ','|explode:$companyData.contact.languages}
                            {foreach $av_langs as $lang}
                                <meta itemprop="availableLanguage" content="{$lang}"/>
                            {/foreach}
                        </div>
                        {if $companyData.contact.mobile}
                            <div itemprop="contactPoint" itemscope itemtype="http://schema.org/ContactPoint">
                                <meta itemprop="telephone" content="{$companyData.contact.mobile}"/>
                                <meta itemprop="contactType" content="customer support"/>
                                {$av_langs = ','|explode:$companyData.contact.languages}
                                {foreach $av_langs as $lang}
                                    <meta itemprop="availableLanguage" content="{$lang}"/>
                                {/foreach}
                            </div>
                        {/if}
                    </ul>
                </div>
            </div>
            {if $companyData.contact.phone}
                <div class="visible-xs pull-right">
                    <ul>
                        <li><span class="fa fa-phone"></span>{$companyData.contact.phone}</li>
                        <li><a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}"><span class="fa fa-envelope"></span></a></li>
                    </ul>
                </div>
            {/if}
            {if $adjust == 'clip'}
        </div>
    </div>
    {/if}
</section>