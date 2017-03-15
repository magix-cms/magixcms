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
    {if !isset($menuclass)}
        {assign var="menuclass" value=''}
    {/if}
{/strip}
<header{if !$menubar} id="header"{/if}>
    {if $toolbar}{include file="section/toolbar.tpl" adjust="clip" gmap=$gmap}{/if}
    <section id="header{if !$menubar}-menu{/if}" role="navigation" class="{if $adjust == 'fluid'}section-block container-fluid{/if}{if !$menubar && $affix} affix{/if}">
        {if $adjust == 'clip'}<div class="container">
            <div class="row">{/if}
                {* Show Nav Button (xs ad sm only) *}
                <button id="toggle-menu" type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target="#main-menu">
                    <span class="sr-only">{#toggleNavigation#|ucfirst}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {* Brand && Headline *}
                <div>
                    <a class="navbar-brand" href="{geturl}/{getlang}/" title="{#logo_link_title#|ucfirst}">
                        <img src="{geturl}/skin/{template}/img/logo/{#logo_img#}" alt="{#logo_img_alt#|ucfirst} {$companyData.name}" width="269" height="50" />
                    </a>
                </div>
                {if ($adjust == 'clip' && !$menubar) || $adjust == 'fluid'}
                    {include file="section/menu/primary.tpl" id="main-menu" type=$menu cclass=$menuclass root=$root submenu=$submenu gmap=$gmap faq=$faq justified=$menubar microData=true}
                {/if}
                {if $adjust == 'clip'}
            </div>
        </div>
        {/if}
        {if $adjust == 'clip' && $menubar}
            {include file="section/menu/primary.tpl" id="main-menu" type=$menu cclass=$menuclass root=$root submenu=$submenu gmap=$gmap faq=$faq justified=$menubar microData=true}
        {/if}
    </section>
</header>