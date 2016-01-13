{extends file="layout.tpl"}
{block name="title"}{cms_seo config_param=['seo'=>$page.seoTitle,'default'=>$page.name]}{/block}
{block name="description"}{cms_seo config_param=['seo'=>$page.seoDescr,'default'=>$page.name]}{/block}
{block name='body:id'}cms{/block}

{block name='article'}
    <article id="article" class="col-xs-12 col-sm-8 col-md-9" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
        {block name='article:content'}
            <h1 itemprop="name">{$page.name}</h1>
            {*<p>
                <small>
                    {#published_on#|ucfirst} <time datetime="{$page.date.register}" itemprop="datePublished">{$page.date.register|date_format:"%e %B %Y"}</time>
                    {if $page.date.update}
                        , {#updated_on#} <time datetime="{$page.date.update}" itemprop="dateModified">{$page.date.update|date_format:"%e %B %Y"}</time>
                    {/if}
                </small>
            </p>*}
            <time datetime="{$page.date.register}" itemprop="datePublished"></time>
            {if $page.date.update}
                <time datetime="{$page.date.update}" itemprop="dateModified"></time>
            {/if}
            <div itemprop="text">
                {$page.content}
            </div>
        {/block}
    </article>
{/block}