<div class="footer-colophon" itemprop="isPartOf" itemscope itemtype="http://schema.org/WebSite" itemref="toolbar">
    <div id="logo" class="col-xs-12 {if $companyData.tva}col-sm-2{else}col-sm-4{/if}">
        <a href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
            <img src="/skin/{template}/img/logo/{#logo_img_small#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="164" height="31" />
        </a>
    </div>
    <div class="col-xs-12 col-sm-4 text-center">
        <p class="footer-copyright"><span class="copyright-info"><span class="fa fa-copyright"></span> <span itemprop="copyrightYear">2016{if 'Y'|date != '2016'} - {'Y'|date}{/if}</span></span>
        | {#footer_all_rights_reserved#|ucfirst}{#footer_all_rights_reserved#|ucfirst}</p>
    </div>
    {if $companyData.tva}
        <div class="col-xs-12 col-sm-2">
            <p id="tva" itemprop="vatID" class="company-tva text-center">{#footer_tva#} {$companyData.tva}</p>
        </div>
    {/if}
    <div class="footer-creator powered col-xs-12 col-sm-4 pull-right">
        {include file="section/footer/powered.tpl"}
    </div>
</div>