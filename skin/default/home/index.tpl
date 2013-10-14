{extends file="layout.tpl"}
{block name="title"}{static_metas param='' dynamic=$home.seoTitle}{/block}
{block name="description"}{static_metas param='' dynamic=$home.seoDescr}{/block}
{block name='body:id'}home{/block}

{block name="article:content"}
    <h1>{$home.name}</h1>
    {$home.content}
{/block}

{block name='aside:content' append}
    {widget_news_display
        conf    =   [
            'level' => 'last-news',
            'limit' => 3
        ]
        pattern = 'sidebar'
        prepend = "<h2 class='lead'>{#last_news#}</h2>"
    }
    {/block}