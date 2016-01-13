{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'2','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}{/block}
{block name='body:id'}catalog-product{/block}
{block name="webType"}ItemPage{/block}

{block name="article:content"}
<div id="product" itemprop="mainEntity" itemscope itemtype="http://schema.org/Product">
    <h1 itemprop="name">{$product.name|ucfirst}</h1>
    {*<meta itemprop="category" content="{$cat.name}{if isset($subcat)} / {$subcat.name}{/if}">*}
    <div itemprop="category" itemscope itemtype="http://schema.org/Series">
        <meta itemprop="name" content="{$cat.name}">
        <meta itemprop="url" content="{$cat.url}">
    </div>
    {if isset($subcat)}
    <div itemprop="category" itemscope itemtype="http://schema.org/Series">
        <meta itemprop="name" content="{$subcat.name}">
        <meta itemprop="url" content="{$subcat.url}">
    </div>
    {/if}
    <div class="row">
        <div id="product-info" class="col-xs-12 col-md-4 text-center">
            <figure{if $product.imgSrc.medium} itemprop="image" itemscope itemtype="http://schema.org/ImageObject"{/if}>
                {if $product.imgSrc.medium}
                    <meta itemprop="contentUrl" content="{$product.imgSrc.large}" />
                    <a href="{$product.imgSrc.large}" class="img-zoom" title="{$product.name}" itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                        <img src="{$product.imgSrc.medium}" alt="{$product.name}" class="img-responsive" itemprop="contentUrl"/>
                    </a>
                {else}
                    <img src="/skin/{template}/img/catalog/product-default.png" alt="{$product.name}" />
                {/if}
            </figure>
            {if $product.price != 0}
            <p class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <span itemprop="price">{$product.price}</span> <span itemprop="priceCurrency" content="EUR">€</span> TTC
            </p>
            {/if}
            <form action="{geturl}/{getlang}/contact/" method="post">
                <p class="lead">Intéressé par {$product.name} ?</p>
                <p>
                    <input type="hidden" name="moreinfo" value="{$product.name}"/>
                    <input id="more-info" type="submit" class="btn btn-flat btn-main-theme" value="{#contact_form#|firststring}" />
                </p>
            </form>

            {widget_catalog_data
                conf =[
                'context'   =>  'product-gallery'
                ]
                assign='galeryProductData'
            }
            {if $galeryProductData != null}
                <section id="gallery">
                    <h3>{#gallery#|ucfirst}</h3>
                    <div class="row">
                        <div class="center-gallery-xs-6">
                            {include file="catalog/loop/gallery.tpl" data=$galeryProductData}
                        </div>
                    </div>
                </section>
            {/if}
        </div>
        <div class="col-xs-12 col-md-8">
            <div class="desc" itemprop="description">
                {$product.content}
            </div>
            {widget_catalog_data
                assign='productRel'
            }
            {if $productRel != null}
                <section id="similar-products" class="product-list">
                    <h3>{#similar_products#|ucfirst}</h3>
                    <div class="row">
                        <div class="center-gallery-sm-6">
                            {include file="catalog/loop/product.tpl" effect="ming" data=$productRel classCol="col-xs-12 col-sm-6" similar=true}
                        </div>
                    </div>
                </section>
            {/if}
        </div>
    </div>
</div>
{/block}