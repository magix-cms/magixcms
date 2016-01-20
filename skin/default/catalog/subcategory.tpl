{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'2','idmetas'=>'1','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'2','idmetas'=>'2','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}{/block}
{block name='body:id'}catalog-subcat{/block}

{block name="article:content"}
    <div id="subcategory" itemprop="mainEntity" itemscope itemtype="http://schema.org/Series">
        {* Subcategory's Description *}
        <h1 itemprop="name">{$subcat.name|ucfirst}</h1>
        <div itemprop="isPartOf" itemscope itemtype="http://schema.org/Series">
            <meta itemprop="name" content="{$cat.name}">
            <meta itemprop="url" content="{$cat.url}">
        </div>
        <div class="desc" itemprop="description">
            {if isset($subcat.imgSrc.medium)}
                <figure class="col-sm-3 pull-right" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                    <meta itemprop="contentUrl" content="{$subcat.imgSrc.large}" />
                    <a href="{$subcat.imgSrc.large}" class="img-zoom" title="{$subcat.name}" itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                        <img src="{$subcat.imgSrc.medium}" alt="{$subcat.name}" class="img-responsive" itemprop="contentUrl"/>
                    </a>
                </figure>
            {/if}
            {$subcat.content}
        </div>
        <hr>

        {* Category's Products *}
        {widget_catalog_data
            conf =[
                'context'   =>  'product',
                'sort'      => ['order'=>'DESC']
                ]
            assign='productData'
        }
        {if $productData != null}
        <div id="listing-product" class="product-list row" itemprop="mainEntity" itemscope itemtype="http://schema.org/ItemList">
            {include file="catalog/loop/product.tpl" data=$productData effect="ming" classCol="col-xs-12 col-sm-6"}
        </div>
        {/if}
    </div>
{/block}