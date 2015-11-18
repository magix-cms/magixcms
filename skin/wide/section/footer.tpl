{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
<footer id="footer"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
    {if $adjust == 'clip'}
    <div class="container">
        <div class="row">
            {/if}
            <div id="block-about" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="footer-copyright">
                    <a href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                        <img class="img-responsive" src="/skin/{template}/img/{#logo_img_small#}" alt="{#logo_img_alt#|ucfirst} {#website_name#}" width="164" height="48" />
                    </a>
                    <span class="copyright-info"><span class="fa fa-copyright"></span> 2015</span>
                    | {#footer_all_rights_reserved#|ucfirst}
                </div>
                {include file="section/brick/powered.tpl"}
            </div>
            <div id="block-last-news" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
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
            <div id="block-contact" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <h4>{#contact_label_title#|ucfirst}</h4>
                <p>
                    {#contact_label_content#} <a href="{geturl}/{getlang}/{#nav_contact_uri#}/" title="{#show_contact_form#|ucfirst}">
                        {#contact_label_link#}
                    </a>
                </p>

                <ul class="contact-list-footer list-unstyled">
                    {if {#contact_phone#}}
                        <li>
                            <span class="fa fa-phone"></span> <strong>{#contact_phone#}</strong>
                        </li>
                    {/if}
                    {if {#contact_fax#}}
                        <li>
                            <span class="fa fa-fax"></span> <strong>{#contact_fax#}</strong>
                        </li>
                    {/if}
                </ul>
                <p class="mailto">
                    Ou par mail à l'adresse :
                    {mailto address={#contact_mail#} encode="hex"}
                </p>
            </div>
            {if $adjust == 'clip'}
        </div>
    </div>
    {/if}
</footer>