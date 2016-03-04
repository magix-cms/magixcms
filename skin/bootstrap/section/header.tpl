{strip}
    {* default,dropdown,tabs,tabs-arrow *}
    {if !isset($menu)}
        {assign var='menu' value='dropdown'}
    {/if}
    {* clip,fluid *}
    {if !isset($adjust)}
        {assign var="adjust" value="clip"}
    {/if}
    {* Default menu roots *}
    {if !isset($root)}
        {assign var="root" value=['home'=>true,'about'=>false,'catalog'=>true,'news'=>true,'contact'=>true]}
    {/if}
    {if !isset($gmap)}
        {assign var="gmap" value=false}
    {/if}
    {if !isset($faq)}
        {assign var="faq" value=false}
    {/if}
    {if !isset($submenu)}
        {assign var="submenu" value=true}
    {/if}
    {if !isset($menubar)}
        {assign var="menubar" value=true}
    {/if}
    {if !isset($affix)}
        {assign var="affix" value=true}
    {/if}
{/strip}
<header>
    {if $displayAdminPanel}
        {include file="section/admin/toolbar.tpl"}
    {/if}
    {if $toolbar}
        {include file="section/toolbar.tpl" adjust="clip"}
    {/if}
    <section id="header" role="navigation" {if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
        {if $adjust == 'clip'}<div class="container">{/if}
            {* Brand && Headline *}
            <div id="navbar-brand">
                <a class="navbar-brand" href="{geturl}" title="{#logo_link_title#|ucfirst}">
                    {capture name="sizes"}
                        (min-width: 1500px) 11vw, (min-width: 1102px) 15vw, (min-width: 768px) 20vw, (min-width: 480px) 30vw, 50vw
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
                        <img src="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png"
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
            </div>
            {* Show Nav Button (xs ad sm only) *}
            <button id="toggle-menu" type="button" class="navbar-toggler hidden-sm-up pull-right collapsed" data-toggle="collapse" data-target="#main-menu">
                <span class="sr-only">{#toggleNavigation#|ucfirst}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {if ($adjust == 'clip' && !$menubar) || $adjust == 'fluid'}
                {include file="section/menu/primary.tpl" id="main-menu" type=$menu root=$root submenu=$submenu gmap=$gmap faq=$faq justified=$menubar microData=true}
            {/if}
        {if $adjust == 'clip'}</div>{/if}
        {if $adjust == 'clip' && $menubar}
            {include file="section/menu/primary.tpl" id="main-menu" type=$menu root=$root submenu=$submenu gmap=$gmap faq=$faq justified=$menubar microData=true}
        {/if}
    </section>
    {if $affix}
    <section id="header-fixed" role="navigation" {if $adjust == 'fluid' || $menubar} class="{if $menubar}affix-menubar{/if}{if $adjust == 'fluid'} section-block container-fluid{/if}"{/if} aria-hidden="true">
        {if $adjust == 'clip'}<div class="container">{/if}
            {if !$menubar}
            {* Brand && Headline *}
            <a class="navbar-brand" href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                <picture class="img-fluid">
                    <!--[if IE 9]><video style="display: none;"><![endif]-->
                    <source type="image/webp"
                            sizes="{$smarty.capture.sizes}"
                            srcset="{geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@167.webp 167w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@200.webp 200w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@269.webp 269w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@333.webp 333w,
                                        {geturl}/skin/{template}/img/logo/webp/logo-{$companyData.name|lower|replace:' ':'_'}@400.webp 400w">
                    <source sizes="{$smarty.capture.sizes}"
                            srcset="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png 167w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png 200w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png 269w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png 333w,
                                        {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@400.png 400w">
                    <!--[if IE 9]></video><![endif]-->
                    <img src="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png"
                         sizes="{$smarty.capture.sizes}"
                         srcset="{geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@167.png 167w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@200.png 200w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@269.png 269w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@333.png 333w,
                                    {geturl}/skin/{template}/img/logo/png/logo-{$companyData.name|lower|replace:' ':'_'}@400.png 400w"
                         alt="{#logo_img_alt#|ucfirst} {$companyData.name}" />
                </picture>
            </a>
            {/if}
            {if $adjust == 'clip' && !$menubar}
                {include file="section/menu/primary.tpl" id="menu-fixed" type=$menu root=$root submenu=$submenu gmap=$gmap faq=$faq justified=$menubar microData=false}
            {/if}
        {if $adjust == 'clip'}</div>{/if}
        {if ($adjust == 'clip' && $menubar) || $adjust == 'fluid'}
            {include file="section/menu/primary.tpl" id="menu-fixed" type=$menu root=$root submenu=$submenu gmap=$gmap faq=$faq justified=$menubar microData=false}
        {/if}
    </section>
    {/if}
</header>