{strip}
    {* Default Meta => Home *}
    {capture name="ogTitle"}{$title}{/capture}
    {capture name="ogDesc"}{$description}{/capture}
    {capture name="ogUrl"}{geturl}{$smarty.server.REQUEST_URI}{/capture}
    {capture name="ogImg"}{geturl}/skin/{template}/img/logo/{#logo_img#}{/capture}
    {capture name="ogType"}website{/capture}
    {capture name="twCard"}summary{/capture}
    {$data = null}

    {switch $smarty.server.SCRIPT_NAME}
        {* Pages *}
    {case '/cms.php' break}
    {$data = $page}
        {* /Pages *}

        {* Catalogue *}
    {case '/catalog.php' break}
    {if $smarty.get.idclc}
        {if $smarty.get.idcls OR $smarty.get.idproduct}
            {if $smarty.get.idproduct}
                {* Produits *}
                {$data = $product}
                {capture name="ogType"}article{/capture}
                {* /Produits *}
            {elseif $smarty.get.idcls}
                {$data = $subcat}
            {/if}
        {else}
            {$data = $cat}
        {/if}
    {/if}
        {* /Catalogue *}

        {* Actualités *}
    {case '/news.php' break}
    {if $smarty.get.tag OR $smarty.get.uri_get_news}
        {if $smarty.get.uri_get_news}
            {$data = $news}
            {capture name="ogType"}article{/capture}
        {/if}
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