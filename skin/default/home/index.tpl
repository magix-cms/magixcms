{extends file="layout.tpl"}
{block name="title"}{static_metas param=$smarty.config.website_name dynamic=$home.seoTitle}{/block}
{block name="description"}{static_metas param=$smarty.config.website_name dynamic=$home.seoDescr}{/block}
{block name='body:id'}home{/block}

{block name="article:content"}
    <h1>{$home.name}</h1>
    {$home.content}
{/block}

{block name='aside:content' append}
    {widget_news_data
        conf =[
        'context' =>  'last-news',
        'limit' => 3
        ]
        assign='newsData'
    }
    <div class="news-list-last sidebar-list">
        <p class="lead">{#last_news#|ucfirst}</p>
        <div class="row">
        {include file="news/loop/sidebar.tpl" data=$newsData}
        </div>
    </div>
    {/block}