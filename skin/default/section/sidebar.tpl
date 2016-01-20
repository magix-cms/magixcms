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
            <div class="nav-sidebar">
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
            <div class="nav-sidebar">
                <h4>{#catalog_navigation#|ucfirst}</h4>
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
            <div class="nav-sidebar">
                <h4>
                    {if $listingData.main.url}<a href="{$listingData.main.url}" title="{$listingData.main.name|ucfirst}">{/if}
                        {$listingData.main.name|ucfirst}
                        {if $listingData.main.url}</a>{/if}
                </h4>
                <ul class="list-unstyled list-inline">
                    {include file="news/loop/tag.tpl" listing=$listingData.listing active=$listingData.active}
                </ul>
            </div>
        {/if}
    {/if}

    {* Common *}
    {if $smarty.server.SCRIPT_NAME == '/plugins.php'}
        {if $smarty.get.magixmod != 'contact'
        && $smarty.get.magixmod != 'gmap'
        && $smarty.get.magixmod != 'about'
        && $smarty.get.magixmod != 'faq'}
            {widget_catalog_data
                conf =[
                    'context' =>  'last-product',
                    'sort'    => ['order'=>'DESC'],
                    'limit'   => 2
                    ]
                assign='productData'
            }
            {if $productData}
                <div class="last-products">
                    <h4>{#last_products#}</h4>
                    <div class="sidebar-list row">
                        {include file="catalog/loop/last-product.tpl" data=$productData classCol="col-xs-12" effect="ming" truncate=100}
                    </div>
                </div>
            {/if}
        {/if}
    {/if}
