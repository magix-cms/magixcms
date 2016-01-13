{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>$cat.name]  category=$cat.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>$cat.name] category=$cat.name}{/block}
{block name='body:id'}catalog-cat{/block}

{block name="article:content"}
    <div id="category" itemprop="mainEntity" itemscope itemtype="http://schema.org/Series">
        <h1 itemprop="name">{$cat.name|ucfirst}</h1>
        <div class="desc" itemprop="description">
            {if isset($cat.imgSrc.medium)}
                <figure class="col-sm-3 pull-right" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                    <meta itemprop="contentUrl" content="{$cat.imgSrc.large}" />
                    <a href="{$cat.imgSrc.large}" class="img-zoom" title="{$cat.name}" itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                        <img src="{$cat.imgSrc.medium}" alt="{$cat.name}" class="img-responsive" itemprop="contentUrl"/>
                    </a>
                </figure>
            {/if}
            {$cat.content}
        </div>
        {widget_catalog_data
            conf =[
                'context' =>  'subcategory'
                ]
            assign='subCategoryData'
        }
        <div class="subcategory-list">
            {include file="catalog/loop/category.tpl" data=$subCategoryData effect="ming"}
        </div>
        {widget_catalog_data
            conf =[
                'context'   =>  'product',
                'sort'      => 'product'
                ]
            assign='productData'
        }
        <div id="listing-product" class="product-list" itemprop="mainEntity" itemscope itemtype="http://schema.org/ItemList">
            {include file="catalog/loop/product.tpl" data=$productData effect="ming"}
        </div>
    </div>
{/block}