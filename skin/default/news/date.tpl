{extends file="news/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>#seo_t_static_news#] category=$tag.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>#seo_t_static_news#] category=$tag.name}{/block}
{block name='body:id'}news-tag{/block}

{block name='article:content'}
    <h1 itemprop="name">{#news_root_h1#|ucfirst} <small>- <span>{if isset($publishDate.month)}{*{$date = '2000-'|cat:$publishDate.month|cat:'-1'}{$date|date_format:'%B'}*}{$publishDate.monthName} {/if}{$publishDate.year}</span></small></h1>
    {widget_news_data
        conf= [
            'date' => [{getlang} => $publishDate],
            'limit' => 6
            ]
        assign="newsData"
        assignPagination="paginationData"
    }
    <div class="news-list row" itemprop="mainEntity" itemscope itemtype="http://schema.org/ItemList">
        {include file="news/loop/news.tpl" data=$newsData}
    </div>
    {if $paginationData}
        <ul class="pagination">
            {include file="section/loop/pagination.tpl" data=$paginationData}
        </ul>
    {/if}
    <div itemprop="isPartOf" itemscope itemtype="http://schema.org/Periodical" itemid="#periodical">
        <meta itemprop="name" content="{#news_root_h1#|ucfirst}"/>
        <meta itemprop="url" content="{geturl}/{getlang}/{#nav_news_uri#}/"/>
    </div>
{/block}