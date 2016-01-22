{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'2','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}{/block}
{block name='body:id'}catalog-product{/block}
{block name="webType"}ItemPage{/block}

{block name='article'}
    <article id="article" class="col-xs-12" itemprop="mainEntity" itemscope itemtype="http://schema.org/Product">
        {block name='article:content'}
            <div class="row">
                <div id="product-info" class="col-xs-12 col-sm-5 col-md-4 text-center">
                    {widget_catalog_data
                        conf =[
                        'context'   =>  'product-gallery',
                        'sort'      => ['order'=>'DESC']
                        ]
                        assign='galeryProductData'
                    }
                    {if $galeryProductData != null}
                        <section id="gallery">
                            <div class="image-gallery">
                                <div class="big-image">
                                    <a id="default" class="img-gallery" href="{$product.imgSrc.large}" rel="productGallery" title="{$product.name}" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                                        <meta itemprop="contentUrl" content="{$product.imgSrc.large}" />
                                        <span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                                            <img itemprop="image" class="img-responsive" src="{$product.imgSrc.small}" alt="{$product.name|ucfirst}" itemprop="contentUrl"/>
                                        </span>
                                    </a>
                                    {foreach $galeryProductData as $k => $item}
                                    <a id="img{$k}" class="img-gallery" href="{$item.imgSrc.medium}" rel="productGallery" title="{$product.name}" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                                        <meta itemprop="contentUrl" content="{$item.imgSrc.medium}" />
                                        <span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                                            <img itemprop="image" class="img-responsive"  src="{$item.imgSrc.small}" alt="{$product.name|ucfirst}" itemprop="contentUrl"/>
                                        </span>
                                    </a>
                                    {/foreach}
                                </div>

                                <div class="thumbs">
                                    <a class="button prev"><span class="fa fa-angle-left"></span></a>
                                    <a class="button next"><span class="fa fa-angle-right"></span></a>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a class="show-img" href="#" data-target="#default">
                                                <img class="img-responsive" src="{$product.imgSrc.small}" alt="{$product.name|ucfirst}"/>
                                            </a>
                                        </li>
                                        {foreach $galeryProductData as $k => $item}
                                        <li>
                                            <a class="show-img" href="#"  data-target="#img{$k}" rel="productGallery">
                                                <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$product.name|ucfirst}"/>
                                            </a>
                                        </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        </section>
                        {*<h3>{#gallery#|ucfirst}</h3>
                        <div class="row">
                            <div class="gallery">
                                {include file="catalog/loop/gallery.tpl" data=$galeryProductData classCol="col-xs-6 col-sm-4 col-md-3"}
                            </div>
                        </div>*}
                    {else}
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
                    {/if}
                </div>
                <div class="content col-xs-12 col-sm-7 col-md-8">
                    <header>
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
                        {if $product.price != 0}
                            <p class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <span itemprop="price">{$product.price}</span> <span itemprop="priceCurrency" content="EUR">€</span> TTC
                            </p>
                        {/if}
                    </header>

                    <div class="desc" itemprop="description">
                        {$product.content}
                    </div>

                    <form action="{geturl}/{getlang}/contact/" method="post">
                        <fieldset>
                            <legend><span>Intéressé par {$product.name}&thinsp;?</span></legend>
                            <p>
                                <input type="hidden" name="moreinfo" value="{$product.name}"/>
                                <input id="more-info" type="submit" class="btn btn-flat btn-main-theme btn-lg" value="{#contact_form#|firststring}" />
                            </p>
                        </fieldset>
                    </form>
                </div>
            </div>

            {widget_catalog_data
                conf =[
                'sort'      => ['order'=>'DESC']
                ]
                assign='productRel'
            }
            {if $productRel != null}
                <section id="similar-products" class="product-list">
                    <h3>{#similar_products#|ucfirst}</h3>
                    <div class="row">
                        <div class="center-gallery-sm-6">
                            {include file="catalog/loop/product.tpl" effect="ming" data=$productRel classCol="col-xs-12 col-sm-3" similar=true}
                        </div>
                    </div>
                </section>
            {/if}
        {/block}
    </article>
{/block}

{block name="aside"}{/block}
