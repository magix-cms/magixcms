{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>#seo_t_static_news#]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>#seo_t_static_news#]}}{/block}
{block name='body:id'}news{/block}

{block name="article:content"}
    <h1>{#news_root_h1#}</h1>
    {widget_news_display}
{/block}

{block name='aside:content' append}
    {widget_catalog_display
    conf = [
    'context' => 'last-product',
    'limit' => 4
    ]
    pattern = 'sidebar'
    prepend = "<p class='lead'>{#last_products#}</p>"
    }
{/block}