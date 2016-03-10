{extends file="layout.tpl"}
{block name="title"}{static_metas param=$smarty.config.website_name dynamic=$home.seoTitle}{/block}
{block name="description"}{static_metas param=$smarty.config.website_name dynamic=$home.seoDescr}{/block}
{block name='body:id'}home{/block}

{block name="breadcrumb"}{/block}

{block name="main:before"}
    {include file="home/brick/carousel.tpl"}
{/block}

{block name='article'}
    <article id="article" class="container" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
        {block name='article:content'}
            <h1 itemprop="name">{$home.name}</h1>
            <div itemprop="text">
                {$home.content}
            </div>
        {/block}
    </article>
{/block}

{block name="main:after"}
    {include file="home/brick/block-good-choice.tpl"}
    {include file="home/brick/main-cat.tpl"}
    {include file="home/brick/last-news.tpl" adjust="clip" filter=false limit="300"}
{/block}