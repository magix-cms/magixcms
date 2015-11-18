{extends file="layout.tpl"}
{block name="title"}{static_metas param=$smarty.config.website_name dynamic=$home.seoTitle}{/block}
{block name="description"}{static_metas param=$smarty.config.website_name dynamic=$home.seoDescr}{/block}
{block name='body:id'}home{/block}

{block name="breadcrumb"}{/block}

{block name="main:before"}{/block}

{block name="main"}
    <main id="content" class="container">
        <div class="row">
            {block name="article:before"}{/block}

            {block name='article'}
                <article id="article" class="col-xs-12 col-sm-12 col-md-12">
                    {block name='article:content'}
                        <h1>{$home.name}</h1>
                        {$home.content}
                    {/block}
                </article>
            {/block}

            {block name="article:after"}{/block}
        </div>
    </main>
{/block}

{block name="main:after"}
    {include file="home/brick/block-good-choice.tpl" orientation="top" icon='icons' links=true icon_size='0'}
    {include file="home/brick/main-cat.tpl"}
    {include file="home/brick/last-news.tpl"}
{/block}