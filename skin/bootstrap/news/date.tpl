{extends file="news/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>#seo_t_static_news#] category=$tag.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>#seo_t_static_news#] category=$tag.name}{/block}
{block name='body:id'}news-tag{/block}

{block name='article'}
    <pre>{$smarty.get|var_dump}</pre>
    <article id="article" class="container" itemprop="mainEntity" itemscope itemtype="http://schema.org/CreativeWorkSeries">
        {block name='article:content'}
            <h1>{#news_root_h1#|ucfirst} <small>- <span itemprop="about">{$tag.name|ucfirst}</span></small></h1>
            {* ## Navigation tags *}{*
            {widget_news_data
            conf= [
            'level'     => 'tag'
            ]
            assign="sidebarData"
            }
            {$listingData = [
                'main' => [
                    'name' => {#news_by_theme#|ucfirst}
                ],
                'listing' => $sidebarData,
                'active' => $smarty.get.tag
            ]}
            {if $listingData}
                <div class="tag-listing">
                    <ul>
                        {include file="news/loop/tag.tpl" main=$listingData.main listing=$listingData.listing active=$listingData.active}
                    </ul>
                </div>
            {/if}*}

            {widget_news_data
                conf= [
                    'date' => [{getlang} =>
                        ['year' => {$publishDate.year}]
                    ],
                    'limit' => 6]
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
        <div itemprop="isPartOf" itemscope itemtype="http://schema.org/Periodical" itemid="#periodical">
            <meta itemprop="name" content="{#news_root_h1#|ucfirst}"/>
            <meta itemprop="url" content="{geturl}/{getlang}/{#nav_news_uri#}/"/>
        </div>
    </article>
{/block}