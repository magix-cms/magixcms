<div class="footer-colophon" itemprop="isPartOf" itemscope itemtype="http://schema.org/WebSite" itemref="toolbar">
    <p id="logo">
        <a href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
            {capture name="sizes"}
                (min-width: 1500px) 8vw, (min-width: 1102px) 12vw, (min-width: 768px) 18vw, (min-width: 480px) 25vw, 40vw
            {/capture}
            <picture>
                <!--[if IE 9]><video style="display: none;"><![endif]-->
                <source type="image/webp"
                        sizes="{$smarty.capture.sizes}"
                        srcset="{geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@167.webp 167w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@200.webp 200w 2x,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@269.webp 269w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@333.webp 333w 2x,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@400.webp 400w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@537.webp 537w 2x">
                <source sizes="{$smarty.capture.sizes}"
                        srcset="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png 167w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png 200w 2x,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png 269w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png 333w 2x,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@400.png 400w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@537.png 537w 2x">
                <!--[if IE 9]></video><![endif]-->
                <img src="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png"
                     sizes="{$smarty.capture.sizes}"
                     srcset="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png 167w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png 200w 2x,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png 269w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png 333w 2x,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@400.png 400w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@537.png 537w 2x"
                     alt="{#logo_img_alt#|ucfirst} {$companyData.name}"
                     class="img-fluid"/>
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