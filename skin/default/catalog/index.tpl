{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>{#seo_t_static_catalog#}]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>{#seo_d_static_catalog#}]}{/block}
{block name='body:id'}catalog{/block}
{block name="webType"}CollectionPage{/block}

{block name='article'}
    <article id="article" class="col-xs-12 col-sm-8 col-md-9 catalog" itemprop="mainEntity" itemscope itemtype="http://schema.org/Series">
        {block name="article:content"}
            <h1 itemprop="name">{#catalog_root_h1#|ucfirst}</h1>
            {widget_catalog_data
            conf =[
            'context' =>  'category'
            ]
            assign='categoryData'
            }
            <div class="product-list row">
                <div class="center-gallery">
                    {include file="catalog/loop/category.tpl" data=$categoryData effect="ming" classCol="col-xs-12 col-sm-6 col-md-4 col-xl-3"}
                </div>
            </div>
        {/block}
    </article>
{/block}
