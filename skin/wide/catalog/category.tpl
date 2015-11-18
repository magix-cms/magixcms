{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>$cat.name]  category=$cat.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>$cat.name] category=$cat.name}{/block}
{block name='body:id'}catalog-cat{/block}

{block name="article:content"}
    <h1>{$cat.name|ucfirst}</h1>
    {$cat.content}
    {widget_catalog_data
    conf =[
    'context' =>  'subcategory'
    ]
    assign='subCategoryData'
    }
    <div class="product-list">
        {include file="catalog/loop/category.tpl" data=$subCategoryData}
    </div>
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