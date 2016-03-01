{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>#seo_t_static_news#]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>#seo_t_static_news#]}{/block}
{block name='body:id'}news{/block}
{block name="webType"}CollectionPage{/block}

{block name='article'}
    <article id="article" class="container" itemprop="mainEntity" itemscope itemtype="http://schema.org/Periodical">
    {block name='article:content'}
        <h1 itemprop="name">{#news_root_h1#|ucfirst}</h1>
        {* ## Navigation tags *}
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
        {/if}

        {widget_news_data
            conf= ['limit' => 6]
            assign="newsData"
            assignPagination="paginationData"
        }
        {if $newsData}
            <div class="news-list row" itemprop="mainEntity" itemscope itemtype="http://schema.org/ItemList">
                {include file="news/loop/news.tpl" data=$newsData}
            </div>
        {/if}

        {if $paginationData}
            <ul class="pagination">
                {include file="section/loop/pagination.tpl" data=$paginationData}
            </ul>
        {/if}
    {/block}
    </article>
{/block}