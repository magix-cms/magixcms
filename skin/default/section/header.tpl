{strip}
    {* default,dropdown *}
    {if !isset($menu)}
        {assign var='menu' value='dropdown'}
    {/if}
    {if !isset($adjust)}
        {assign var="adjust" value="clip"}
    {/if}
    {if !isset($gmap)}
        {assign var="gmap" value=false}
    {/if}
{/strip}
<header>
    {if $toolbar}
        {include file="section/toolbar.tpl" adjust="clip"}
    {/if}
    <section id="header" role="navigation"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
        {if $adjust == 'clip'}<div class="container">
            <div class="row">{/if}
                {* Show Nav Button (xs ad sm only) *}
                <button id="toggle-menu" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-primary-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {* Brand && Headline *}
                <div id="navbar-brand" itemprop="copyrightHolder" itemscope itemtype="http://schema.org/{$companyData.type}" itemref="{if $companyData.tva}tva {/if}socials-links address contactPoint contactPointMobile">
                    <a class="navbar-brand" href="{geturl}" title="{#logo_link_title#|ucfirst}" itemprop="url">
                        <img itemprop="logo" class="img-responsive" src="{geturl}/skin/{template}/img/{#logo_img#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="269" height="50" />
                        <meta itemprop="name" content="{$companyData.name}"/>
                        <meta itemprop="brand" content="{$companyData.name}"/>
                        {if $about != null}
                            <meta itemprop="sameAs" content="{geturl}/{getlang}/about/"/>
                        {/if}
                        {if $gmap}
                            <meta itemprop="hasMap" content="{geturl}/{getlang}/gmap/"/>
                        {/if}
                    </a>
                </div>
                {include file="section/menu/primary.tpl" id="nav-primary-collapse" type=$menu root=['about'=>false] submenu=false gmap=$gmap faq=false justified=false microData=true}
                {if $adjust == 'clip'}
            </div>
        </div>
        {/if}
    </section>
    <section id="header-fixed" role="navigation" data-spy="affix" data-offset-top="71"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
        {if $adjust == 'clip'}
        <div class="container">
            <div class="row">
                {/if}
            {* Brand && Headline *}
            <a class="navbar-brand" href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                <img class="img-responsive" src="/skin/{template}/img/{#logo_img_affix#}" alt="{#logo_img_alt#|ucfirst}" />
            </a>
            {include file="section/menu/primary.tpl" id="nav-primary-fixed" type=$menu root=['about'=>false] submenu=false gmap=$gmap faq=false justified=false microData=false}
                {if $adjust == 'clip'}
            </div>
        </div>
        {/if}
    </section>
</header>