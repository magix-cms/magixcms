<section id="sidebar" class="col-xs-12 col-sm-4 col-md-3">
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
        <div class="nav-sidebar">
            <h4>
                {if $listingData.main.url}<a href="{$listingData.main.url}" title="{$listingData.main.name|ucfirst}">{/if}
                    {$listingData.main.name|ucfirst}
                    {if $listingData.main.url}</a>{/if}
            </h4>
            <ul class="list-unstyled list-inline tag-listing">
                {include file="news/loop/tag.tpl" listing=$listingData.listing active=$listingData.active}
            </ul>
        </div>
    {/if}
    {include file="news/brick/archives.tpl"}
</section>