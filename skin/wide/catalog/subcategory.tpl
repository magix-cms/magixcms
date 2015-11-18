{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'2','idmetas'=>'1','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'2','idmetas'=>'2','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}{/block}
{block name='body:id'}catalog-subcat{/block}

{block name="article:content"}
    <h1>{$subcat.name|ucfirst}</h1>
    {$subcat.content}
    {* Modele with catalog display *}
    {*{widget_catalog_display
        pattern = 'product'
    }*}
    {* Modele with catalog data *}
    {widget_catalog_data
        conf =[
        'context'   =>  'product',
        'sort'      => 'product'
        ]
        assign='productData'
    }
    {*<pre>{$productData|print_r}</pre>*}
    <div id="listing-product" class="product-list">
        {include file="catalog/loop/product.tpl" data=$productData}
    </div>
{/block}