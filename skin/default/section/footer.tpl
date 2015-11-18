{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
<footer id="footer"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
    {if $adjust == 'clip'}
    <div class="container">
        <div class="row">
            {/if}
            <div id="block-about" class="col-xs-12 col-sm-4">
                <div id="copyright" class="footer-copyright" itemprop="isPartOf" itemscope itemtype="http://schema.org/WebSite" itemref="org">
                    <a href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                        <img class="img-responsive" src="/skin/{template}/img/{#logo_img_small#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="164" height="48" />
                    </a>
                    <span class="copyright-info"><span class="fa fa-copyright"></span> <span itemprop="copyrightYear">2015</span></span>
                    | {#footer_all_rights_reserved#|ucfirst}
                </div>
                {if $companyData.tva}
                    <p id="tva" itemprop="vatID" class="company-tva">{#footer_tva#} {$companyData.tva}</p>
                {/if}
                {include file="section/brick/powered.tpl"}
            </div>
            <div id="block-last-news" class="col-xs-12 col-sm-4">
                {widget_news_data
                conf =[
                'context' =>  'last-news',
                'limit' => 2
                ]
                assign='newsFooterData'
                }
                <h4><a href="{geturl}/{getlang}/{#nav_news_uri#}/" title="{#show_news#|ucfirst}">{#last_news#|ucfirst}</a></h4>
                <div class="news-list-last">
                    {include file="news/loop/footer.tpl" data=$newsFooterData}
                </div>
            </div>
            <div id="block-contact" class="col-xs-12 col-sm-4 pull-right">
                <h4>{#contact_label_title#|ucfirst}</h4>
                <p>
                    {#contact_label_content#} <a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}">
                        {#contact_label_link#}
                    </a>
                </p>

                <ul class="contact-list-footer list-unstyled">
                    {if $companyData.contact.phone}
                        <li>
                            <span class="fa fa-phone"></span> <strong>{$companyData.contact.phone}</strong>
                        </li>
                    {/if}
                    {if $companyData.contact.mobile}
                        <li>
                            <span class="fa fa-mobile"></span> <strong>{$companyData.contact.mobile}</strong>
                        </li>
                    {/if}
                    {if $companyData.contact.fax}
                        <li>
                            <span class="fa fa-fax"></span> <strong>{$companyData.contact.fax}</strong>
                        </li>
                    {/if}
                </ul>
                {if $companyData.contact.mail}
                    <p class="mailto">
                        {#contact_label_mail#}
                        {mailto address={$companyData.contact.mail} encode="hex"}
                    </p>
                {/if}
            </div>
            {if $adjust == 'clip'}
        </div>
    </div>
    {/if}
</footer>