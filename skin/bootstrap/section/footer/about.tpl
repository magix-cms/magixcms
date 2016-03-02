<div class="footer-colophon" itemprop="isPartOf" itemscope itemtype="http://schema.org/WebSite" itemref="toolbar">
    <p id="logo">
        <a href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
            {*<img src="/skin/{template}/img/logo/{#logo_img_small#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="164" height="31" />*}
            <picture class="img-fluid">
                <!--[if IE 9]><video style="display: none;"><![endif]-->
                <source type="image/webp"
                        sizes="18vh"
                        srcset="{geturl}/skin/{template}/img/logo/webp/logo-magix_cms@167.webp 167w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-magix_cms@200.webp 200w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-magix_cms@269.webp 269w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-magix_cms@333.webp 333w">
                <source sizes="18vh"
                        srcset="{geturl}/skin/{template}/img/logo/png/logo-magix_cms@167.png 167w,
                                        {geturl}/skin/{template}/img/logo/png/logo-magix_cms@200.png 200w,
                                        {geturl}/skin/{template}/img/logo/png/logo-magix_cms@269.png 269w,
                                        {geturl}/skin/{template}/img/logo/png/logo-magix_cms@333.png 333w">
                <!--[if IE 9]></video><![endif]-->
                <img src="{geturl}/skin/{template}/img/logo/png/logo-magix_cms@167.png"
                     sizes="18vh"
                     srcset="{geturl}/skin/{template}/img/logo/png/logo-magix_cms@167.png 167w,
                                    {geturl}/skin/{template}/img/logo/png/logo-magix_cms@200.png 200w,
                                    {geturl}/skin/{template}/img/logo/png/logo-magix_cms@269.png 269w,
                                    {geturl}/skin/{template}/img/logo/png/logo-magix_cms@333.png 333w"
                     alt="{#logo_img_alt#|ucfirst} {$companyData.name}" />
            </picture>
        </a>
    </p>
    <p class="footer-copyright text-center"><span class="copyright-info">
        <span class="fa fa-copyright"></span> <span itemprop="copyrightYear">2016{if 'Y'|date != '2016'} - {'Y'|date}{/if}</span></span> | {#footer_all_rights_reserved#|ucfirst}
    </p>
    {if $companyData.tva}
        <p id="tva" itemprop="vatID" class="company-tva text-center">{#footer_tva#} {$companyData.tva}</p>
    {/if}
    {include file="section/footer/powered.tpl"}
</div>