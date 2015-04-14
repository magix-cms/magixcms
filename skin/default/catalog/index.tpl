{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>{#seo_t_static_catalog#}]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>{#seo_d_static_catalog#}]}{/block}
{block name='body:id'}catalog{/block}

{block name="article:content"}
    <h1>{#catalog_root_h1#|ucfirst}</h1>
    {widget_catalog_data
        conf =[
        'context' =>  'category'
        ]
        assign='categoryData'
    }
    <div class="product-list">
        {include file="catalog/loop/category.tpl" data=$categoryData}
    </div>
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