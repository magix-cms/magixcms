{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>{#seo_t_static_catalog#}]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>{#seo_d_static_catalog#}]}{/block}
{block name='body:id'}catalog{/block}
{block name="webType"}CollectionPage{/block}

{block name="article:content"}
    <div id="catalog-root" itemprop="mainEntity" itemscope itemtype="http://schema.org/Series">
        <h1 itemprop="name">{#catalog_root_h1#|ucfirst}</h1>
        {widget_catalog_data
            conf =[
            'context' =>  'category'
            ]
            assign='categoryData'
        }
        <div class="product-list row">
            {include file="catalog/loop/category.tpl" data=$categoryData effect="ming"}
        </div>
    </div>
{/block}
