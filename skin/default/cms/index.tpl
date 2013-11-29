{extends file="layout.tpl"}
{block name="title"}{cms_seo config_param=['seo'=>$page.seoTitle,'default'=>$page.name]}{/block}
{block name="description"}{cms_seo config_param=['seo'=>$page.seoDescr,'default'=>$page.name]}{/block}
{block name='body:id'}cms{/block}

{block name="article:content"}
    <h1>{$page.name}</h1>
    <p>
        <small>
            {#published_on#|ucfirst} {$page.date.register}
            {if $page.date.update}
                , {#updated_on#} {$page.date.update}
            {/if}
        </small>
    </p>
    {$page.content}
{/block}