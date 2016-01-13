{extends file="news/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>#seo_t_static_news#] category=$tag.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>#seo_t_static_news#] category=$tag.name}{/block}
{block name='body:id'}news-tag{/block}

{block name='article'}
    <article id="article" class="col-xs-12 col-sm-8 col-md-9" itemprop="mainEntity" itemscope itemtype="http://schema.org/CreativeWorkSeries">
        <div itemprop="isPartOf" itemscope itemtype="http://schema.org/Periodical" itemid="#periodical">
            <meta itemprop="name" content="{#news_root_h1#|ucfirst}"/>
            <meta itemprop="url" content="{geturl}/{getlang}/{#nav_news_uri#}/"/>
        </div>
        {block name='article:content'}
            <h1>{#news_root_h1#|ucfirst} <small>- <span itemprop="about">{$tag.name|ucfirst}</span></small></h1>
            {widget_news_data
                conf= ['limit' => 6]
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
        {/block}
    </article>
{/block}