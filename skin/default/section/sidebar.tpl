    {* # CMS *}
    {if $smarty.server.SCRIPT_NAME == '/cms.php' OR $smarty.server.SCRIPT_NAME == '/index.php'}
        {* ## Navigation *}
        {$parent = ($smarty.get.getidpage_p) ? $smarty.get.getidpage_p : $smarty.get.getidpage}
        {widget_cms_data
            conf = [
                'context' => 'all',
                'level' => 'all'
            ]
            assign="sidebarData"
        }
        {* select data with conf 'select' => [$smarty.get.strLangue => $parent] *}
        {if $sidebarData}
            <div id="nav-sidebar">
                {include file="cms/loop/sidebar.tpl" data=$sidebarData parent=$parent}
            </div>
        {/if}
    {/if}
    {* # Catalog *}
    {if $smarty.server.SCRIPT_NAME == '/catalog.php'}
        {* ## Navigation *}
        {widget_catalog_data
        conf = [
        'context' => ['category' => 'subcategory']
        ]
        assign="sidebarData"
        }
        {if $sidebarData}
            <div id="nav-sidebar">
                {include file="catalog/loop/sidebar.tpl" data=$sidebarData}
            </div>
        {/if}
    {/if}
    {* # News *}
    {if $smarty.server.SCRIPT_NAME == '/news.php'}
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
            <div id="nav-sidebar">
                <h3>
                    {if $listingData.main.url}<a href="{$listingData.main.url}" title="{$listingData.main.name|ucfirst}">{/if}
                        {$listingData.main.name|ucfirst}
                        {if $listingData.main.url}</a>{/if}
                </h3>
                <ul class="list-unstyled list-inline">
                    {include file="news/loop/tag.tpl" listing=$listingData.listing active=$listingData.active}
                </ul>
            </div>
        {/if}
        {widget_catalog_data
            conf =[
                'context' =>  'last-product',
                'sort' => 'product',
                'limit' => 2
                ]
            assign='productData'
        }
        {if $listingData}
            <div class="news-list-last">
                <h3>{#last_products#}</h3>
                <div class="sidebar-list row">
                    {include file="catalog/loop/last-product.tpl" data=$productData classCol="col-xs-12" effect="ming"}
                </div>
            </div>
        {/if}
    {/if}
