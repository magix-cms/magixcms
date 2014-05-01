{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>#seo_t_static_news#]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>#seo_t_static_news#]}}{/block}
{block name='body:id'}news{/block}

{block name="article:content"}
    <h1>{#news_root_h1#}</h1>
    {widget_news_data
        conf= ['limit' => 6]
        assign="newsData"
        assignPagination="paginationData"
    }
    <div class="news-list row">
        {include file="news/loop/news.tpl"
        data=$newsData
        }
    </div>
    {if $paginationData}
        <ul class="pagination">
            {include file="section/loop/pagination.tpl" data=$paginationData}
        </ul>
    {/if}
{/block}

{block name='aside:content' append}
    {widget_catalog_data
        conf =[
        'context' =>  'last-product',
        'sort' => 'product',
        'limit' => 4
        ]
        assign='productData'
    }
    <div class="news-list-last sidebar-list row">
        {include file="catalog/loop/last-product.tpl" data=$productData}
    </div>
{/block}