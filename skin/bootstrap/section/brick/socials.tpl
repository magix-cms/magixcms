{strip}
    {* Default Meta => Home *}
    {capture name="ogTitle"}{$title}{/capture}
    {capture name="ogDesc"}{$description}{/capture}
    {capture name="ogUrl"}{geturl}{/capture}
    {capture name="ogImg"}{geturl}/skin/{template}/img/logo-magix_cms.png{/capture}
    {capture name="ogType"}website{/capture}
    {capture name="twCard"}summary{/capture}
    {$data = null}

    {switch $smarty.server.SCRIPT_NAME}
    {* Pages *}
    {case '/cms.php' break}
        {$data = $page}
        {capture name="ogUrl"}{geturl}{$page.url}{/capture}
    {* /Pages *}

    {* Catalogue *}
    {case '/catalog.php' break}
        {if $smarty.get.idclc}
            {if $smarty.get.idcls OR $smarty.get.idproduct}
                {if $smarty.get.idproduct}
                    {* Produits *}
                    {$data = $product}
                    {capture name="ogUrl"}{geturl}{$data.url}{/capture}
                    {capture name="ogType"}article{/capture}
                    {* /Produits *}
                {elseif $smarty.get.idcls}
                    {* Sous-catégories *}
                    {capture name="ogUrl"}{geturl}{$subcat.url}{/capture}
                    {* /Sous-catégories *}
                {/if}
            {else}
                {* Catégories *}
                {capture name="ogUrl"}{geturl}{$cat.url}{/capture}
                {* /Catégories *}
            {/if}
        {else}
            {* Root *}
            {capture name="ogUrl"}{geturl}/{getlang}/{#nav_catalog_uri#}/{/capture}
            {* /Root *}
        {/if}
    {* /Catalogue *}

    {* Actualités *}
    {case '/news.php' break}
        {if $smarty.get.tag OR $smarty.get.uri_get_news}
            {if $smarty.get.tag}
                {* Tag *}
                {capture name="ogUrl"}{geturl}/{#nav_news_uri#}/tag/{$smarty.get.tag}/{/capture}
                {* /Tag *}
            {elseif $smarty.get.uri_get_news}
                {* News *}
                {$data = $news}
                {capture name="ogUrl"}{geturl}{$data.uri}{/capture}
                {capture name="ogType"}article{/capture}
                {* /News *}
            {/if}
        {else}
            {* Root *}
            {capture name="ogUrl"}{geturl}/{getlang}/{#nav_news_uri#}/{/capture}
            {* /Root *}
        {/if}
    {* /Actualités *}
    {/switch}

    {if $data != null}
        {if $data.imgSrc.medium}
            {capture name="ogImg"}{geturl}{$data.imgSrc.medium}{/capture}
        {/if}
    {/if}

    {$meta = [
        'og:site_name' => {$companyData.name},
        'twitter:site' => {#twitter_pseudo#},
        'twitter:card' => $smarty.capture.twCard,
        'og:title' => $smarty.capture.ogTitle,
        'og:description' => $smarty.capture.ogDesc,
        'og:url' => $smarty.capture.ogUrl,
        'og:image' => $smarty.capture.ogImg,
        'og:type' => $smarty.capture.ogType
        ]
    }
{/strip}
<meta property="og:site_name" content="{$meta['og:site_name']}" />
{if $meta['twitter:site'] ne '0'}
    <meta name="twitter:site" content="{$meta['twitter:site']}" />
    <meta name="twitter:card" content="{$meta['twitter:card']}" />
{/if}
    <meta property="og:title" content="{$meta['og:title']}" />
    <meta property="og:description" content="{$meta['og:description']}" />
    <meta property="og:url" content="{$meta['og:url']}" />
    <meta property="og:image" content="{$meta['og:image']}" />
    <meta property="og:type" content="{$meta['og:type']}" />