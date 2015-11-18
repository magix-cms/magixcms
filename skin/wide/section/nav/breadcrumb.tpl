{if !isset($adjust)}
    {assign var="adjust" value="clip"}
{/if}
{if $adjust == 'clip'}
<div class="container">
    <div class="row">
        {/if}
        {* Share tools *}
        {widget_share_data assign="shareData"}
        <div class="share-box pull-right col-md-4">
            <ul id="share-nav" class="list-inline">
                {include file="section/loop/share.tpl" data=$shareData}
            </ul>
        </div>
        {assign var=bread value=array()}

        {* Home *}
        {if $smarty.server.SCRIPT_NAME != '/index.php'}
            {$bread[] = ['name' => {#home#},'url' => "{geturl}/{getlang}/",'title' => {#show_home#}]}
        {else}
            {$bread[] = ['name' => {#home#}]}
        {/if}
        {* /Home *}

        {* Pages *}
        {if $smarty.server.SCRIPT_NAME == '/cms.php'}
            {* Parent *}
            {if $smarty.get.getidpage_p}
                {$bread[] = ['name' => {$parent.name},'url' => "{geturl}{$parent.url}",'title' => "{#show_page#}: {$parent.name}"]}
            {/if}
            {* /Parent *}

            {$bread[] = ['name' => {$page.name}]}
        {/if}
        {* /Pages *}

        {* Catalogue *}
        {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
            {if $smarty.get.idclc}
                {* Root *}
                {*{$bread[] = ['name' => {#catalog#},'url' => "{geturl}/{getlang}/{#nav_catalog_uri#}/",'title' => {#show_catalog#}]}*}

                {* Catégories *}
                {if $smarty.get.idcls OR $smarty.get.idproduct}
                    {$bread[] = ['name' => {$cat.name},'url' => "{geturl}{$cat.url}",'title' => "{#show_category#}: {$cat.name}"]}

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
                {$bread[] = ['name' => {#plan_acces#}]}
            {/if}
        {/if}
        {* /Plugins *}

        <ol id="breadcrumb" class="breadcrumb hidden-xs">
            {foreach from=$bread item=breadcrumb}
                <li>
                    {if isset($breadcrumb.url)}
                        <a href="{$breadcrumb.url}" title="{$breadcrumb.title|ucfirst}">
                            {$breadcrumb.name|ucfirst}
                        </a>
                    {else}
                        {$breadcrumb.name|ucfirst}
                    {/if}
                </li>
            {/foreach}
        </ol>

        {if !isset($collapse)}
            {$collapse = true}
        {/if}
        {$length = $bread|count}

        <ol id="compact-breadcrumb" class="breadcrumb hidden-sm hidden-md hidden-lg">
            {foreach from=$bread item=breadcrumb key=i}
                {if $length > 3 && $i == 1 && $collapse}
                    <li id="hellipsis">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#breadcrumb-collapse">
                        <span class="sr-only">{#toggle_nav#|ucfirst}</span>
                        <span class="fa fa-ellipsis-h"></span>
                    </button>
                    <ol id="breadcrumb-collapse" class="collapse navbar-collapse">
                {/if}

                <li>
                    {if isset($breadcrumb.url)}
                        <a href="{$breadcrumb.url}" title="{$breadcrumb.title|ucfirst}">
                            {$breadcrumb.name|ucfirst}
                        </a>
                    {else}
                        {$breadcrumb.name|ucfirst}
                    {/if}
                </li>

                {if $length > 3 && $i == $length-2 && $collapse}
                    </ol>
                    </li>
                {/if}
            {/foreach}
        </ol>
        {if $adjust == 'clip'}
    </div>
</div>
{/if}
