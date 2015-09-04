    {* default,dropdown *}
    {if !isset($menu)}
        {assign var='menu' value='dropdown'}
    {/if}
    {if !isset($adjust)}
        {assign var="adjust" value="clip"}
    {/if}
    <header>
        <section id="header" role="navigation"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
            {if $adjust == 'clip'}
            <div class="container">
                <div class="row">
                    {/if}
                    {* Show Nav Button (xs ad sm only) *}
                    <button id="toggle-menu" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-primary-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {* Brand && Headline *}
                    <a id="navbar-brand" class="navbar-brand" href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                        <img class="img-responsive" src="/skin/{template}/img/{#logo_img#}" alt="{#logo_img_alt#|ucfirst} {#website_name#}" width="269" height="50" />
                    </a>
                    {include file="section/menu/primary.tpl" id="nav-primary-collapse" type=$menu}
                    {if $adjust == 'clip'}
                </div>
            </div>
            {/if}
        </section>
        <section id="header-fixed" role="navigation" data-spy="affix" data-offset-top="150"{if $adjust == 'fluid'} class="section-block container-fluid"{/if}>
            {if $adjust == 'clip'}
            <div class="container">
                <div class="row">
                    {/if}
                {* Brand && Headline *}
                <a class="navbar-brand" href="/{getlang}/" title="{#logo_link_title#|ucfirst}">
                    <img class="img-responsive" src="/skin/{template}/img/{#logo_img_affix#}" alt="{#logo_img_alt#|ucfirst}" />
                </a>
                {include file="section/menu/primary.tpl" id="nav-primary-fixed" type=$menu}
                    {if $adjust == 'clip'}
                </div>
            </div>
            {/if}
        </section>
    </header>