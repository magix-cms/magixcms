<div class="footer-colophon" itemprop="isPartOf" itemscope itemtype="http://schema.org/WebSite" itemref="toolbar">
    <p id="logo">
        <a href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
            <img src="/skin/{template}/img/logo/{#logo_img_small#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="164" height="31" />
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