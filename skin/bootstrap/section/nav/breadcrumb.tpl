{strip}
{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
{if !isset($adjust)}
    {assign var="icon" value=false}
{/if}
{if !isset($catalog)}
    {assign var="catalog" value=true}
{/if}
{if !isset($quickAccess)}
    {assign var="quickAccess" value=true}
{/if}
{/strip}
{if $adjust == 'clip'}<div class="container">{/if}
    {strip}
    {assign var=bread value=array()}

    {* Home *}
        {if $icon}
            {$hname = "<span class=\"fa fa-{$icon}\"></span>"}
        {else}
            {$hname = {#home#}}
        {/if}
    {if $smarty.server.SCRIPT_NAME != '/index.php'}
        {$bread[] = ['name' => {$hname},'url' => "{geturl}/{getlang}/",'title' => {#show_home#}]}
    {else}
        {$bread[] = ['name' => {$hname}]}
    {/if}
    {* /Home *}

    {* Pages *}
    {if $smarty.server.SCRIPT_NAME == '/cms.php'}
        {* Parent *}
        {if $smarty.get.getidpage_p}
            {if $quickAccess}
            {widget_cms_data
                conf = [
                    'select' => [{getlang} => {$smarty.get.getidpage_p}],
                    'context' => 'child'
                    ]
                assign = 'submenu'
            }
            {$bread[] = ['name' => {$parent.name},'url' => "{geturl}{$parent.url}",'title' => "{#show_page#}: {$parent.name}",'submenu' => $submenu]}
            {else}
            {$bread[] = ['name' => {$parent.name},'url' => "{geturl}{$parent.url}",'title' => "{#show_page#}: {$parent.name}"]}
            {/if}
        {/if}
        {* /Parent *}

        {$bread[] = ['name' => {$page.name}]}
    {/if}
    {* /Pages *}

    {* Catalogue *}
    {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
        {if $smarty.get.idclc}
            {* Root *}
            {if $catalog}
                {if $quickAccess}
                    {widget_catalog_data
                        conf = [
                            'context' => 'category'
                            ]
                        assign = 'submenu'
                    }
                    {$bread[] = ['name' => {#catalog#},'url' => "{geturl}/{getlang}/{#nav_catalog_uri#}/",'title' => {#show_catalog#},'submenu'=>$submenu]}
                {else}
                    {$bread[] = ['name' => {#catalog#},'url' => "{geturl}/{getlang}/{#nav_catalog_uri#}/",'title' => {#show_catalog#}]}
                {/if}
            {/if}

            {* Catégories *}
            {if $smarty.get.idcls OR $smarty.get.idproduct}
                {if $quickAccess}
                    {widget_catalog_data
                        conf = [
                            'select' => [{getlang} => {$smarty.get.idclc}],
                            'context' => ['category' => 'subcategory']
                            ]
                        assign = 'submenu'
                    }
                    {$bread[] = ['name' => {$cat.name},'url' => "{geturl}{$cat.url}",'title' => "{#show_category#}: {$cat.name}",'submenu'=>$submenu[0].subdata]}
                {else}
                    {$bread[] = ['name' => {$cat.name},'url' => "{geturl}{$cat.url}",'title' => "{#show_category#}: {$cat.name}"]}
                {/if}

                {* Sous-catégories *}
                {if $smarty.get.idcls AND $smarty.get.idproduct}
                    {$bread[] = ['name' => {$subcat.name},'url' => "{geturl}{$subcat.url}",'title' => "{#show_subcategory#}: {$subcat.name}"]}
                {elseif $smarty.get.idcls}
                    {$bread[] = ['name' => {$subcat.name}]}
                {/if}
                {* /Sous-catégories *}

                {* Produits *}
                {if $smarty.get.idproduct}
                    {$bread[] = ['name' => {$product.name}]}
                {/if}
                {* /Produits *}
            {else}
                {$bread[] = ['name' => {$cat.name}]}
            {/if}
            {* /Catégories *}
        {else}
            {$bread[] = ['name' => {#catalog#}]}
        {/if}
        {* /Root *}
    {/if}
    {* /Catalogue *}

    {* Actualités *}
    {if $smarty.server.SCRIPT_NAME == '/news.php'}
        {* Root *}
        {if $smarty.get.tag OR $smarty.get.uri_get_news}
            {$bread[] = ['name' => {#news#},'url' => "{geturl}/{getlang}/{#nav_news_uri#}/",'title' => {#show_news#}]}
        {else}
            {$bread[] = ['name' => {#news#}]}
        {/if}
        {* /Root *}

        {* Tag *}
        {if $smarty.get.tag}
            {$bread[] = ['name' => "{#theme#}: {$tag.name}"]}
        {/if}
        {* /Tag *}

        {* News *}
        {if $smarty.get.uri_get_news}
            {$bread[] = ['name' => {$news.name}]}
        {/if}
        {* /News *}
    {/if}
    {* /Actualités *}

    {* Plugins *}
    {if $smarty.server.SCRIPT_NAME == '/plugins.php'}
        {if $smarty.get.magixmod == 'contact'}
            {$bread[] = ['name' => {#contact_form#}]}
        {/if}
        {if $smarty.get.magixmod == 'gmap'}
            {$bread[] = ['name' => {#contact_form#},'url' => "{geturl}/{getlang}/{#nav_contact_uri#}/",'title' => {#contact_label#}]}
            {$bread[] = ['name' => {#plan_acces#}]}
        {/if}
        {if $smarty.get.magixmod == 'about'}
            {if $smarty.get.pnum1}
                {$bread[] = ['name' => {$parent.title},'url' => "{geturl}/{getlang}/about/",'title' => "{#show_page#}: {$parent.title}"]}
                {$bread[] = ['name' => {$page.title}]}
            {else}
                {$bread[] = ['name' => {$page.title}]}
            {/if}
        {/if}
        {if $smarty.get.magixmod == 'faq'}
            {$bread[] = ['name' => {#faq#}]}
        {/if}
    {/if}
    {* /Plugins *}

    {if !isset($collapse)}
        {$collapse = true}
    {/if}
    {$length = $bread|count}
    {/strip}
    <nav id="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
        <ol class="breadcrumb">
        {foreach $bread as $breadcrumb}
            {if $length > 3 && $breadcrumb@index == 1 && $collapse}
            <li id="hellipsis" class="hidden-sm-up">
                <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#breadcrumb-collapse">
                    <span class="sr-only">{#toggle_nav#|ucfirst}</span>
                    <span class="fa fa-ellipsis-h"></span>
                </button>
            </li>
            {/if}

            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"{if $length > 3 && $breadcrumb@index > 0 && $breadcrumb@index < $length-1 && $collapse} class="hidden-xs-down"{/if}>
                {if isset($breadcrumb.url)}
                    <a href="{$breadcrumb.url}" title="{$breadcrumb.title|ucfirst}" itemprop="item"{if isset($breadcrumb.submenu)} class="hasSubmenu"{/if}>
                        <span itemprop="name">{$breadcrumb.name|ucfirst}</span>
                        <meta itemprop="position" content="{($breadcrumb@index + 1)}" />
                    </a>
                    {if isset($breadcrumb.submenu) && !empty($breadcrumb.submenu)}
                    <ul class="submenu list-unstyled hidden-xs-down">
                    {foreach $breadcrumb.submenu as $item}
                        <li><a href="{$item.url}">{$item.name}</a></li>
                    {/foreach}
                    </ul>
                    {/if}
                {else}
                    <span itemprop="item">
                        <span itemprop="name">{$breadcrumb.name|ucfirst}</span>
                        <meta itemprop="position" content="{($breadcrumb@index + 1)}" />
                    </span>
                {/if}
            </li>
        {/foreach}
        </ol>
    </nav>
    {if $length > 3 && $collapse}
        <div id="breadcrumb-collapse" class="hidden-sm-up collapse navbar-toggleable-xs">
            <ol class="breadcrumb">
                {foreach $bread as $breadcrumb}
                    {if $breadcrumb@index > 0 && $breadcrumb@index < $length-1}
                        <li>
                            {if isset($breadcrumb.url)}
                                <a href="{$breadcrumb.url}" title="{$breadcrumb.title|ucfirst}">
                                    {$breadcrumb.name|ucfirst}
                                </a>
                            {else}
                            {/if}
                        </li>
                    {/if}
                {/foreach}
            </ol>
        </div>
    {/if}
{if $adjust == 'clip'}</div>{/if}
