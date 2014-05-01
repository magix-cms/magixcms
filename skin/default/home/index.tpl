{extends file="layout.tpl"}
{block name="title"}{static_metas param='' dynamic=$home.seoTitle}{/block}
{block name="description"}{static_metas param='' dynamic=$home.seoDescr}{/block}
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
    <div class="news-list-last sidebar-list row">
        {include file="news/loop/sidebar.tpl" data=$newsData}
    </div>
    {/block}