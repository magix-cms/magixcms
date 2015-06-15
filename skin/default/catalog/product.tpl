{extends file="catalog/index.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'3','idmetas'=>'2','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}{/block}
{block name='body:id'}catalog-product{/block}

{block name="article:content"}
    <h1>{$product.name|ucfirst}</h1>
    <div class="row">
        <div id="product-info" class="col-xs-12 col-md-4 text-center">
            <div class="well well-lg">
                {if $product.imgSrc.medium}
                    <a href="{$product.imgSrc.large}" class="img-zoom" title="{$product.name}">
                        <img src="{$product.imgSrc.medium}" alt="{$product.name}" class="img-responsive" />
                    </a>
                {else}
                    <img src="/skin/{template}/img/catalog/product-default.png" alt="{$product.name}" />
                {/if}
                <p>
                    {if $product.price != 0}
                        <span class="price">{$product.price} € TTC</span>
                    {/if}
                </p>
                <form action="{geturl}/{getlang}/contact/" method="post">
                    <p class="lead">Intéressé par {$product.name} ?</p>
                    <p>
                        <input type="hidden" name="moreinfo" value="{$product.name}"/>
                        <input id="more-info" type="submit" class="btn btn-primary" value="{#contact_form#|firststring}" />
                    </p>
                </form>
            </div>
            {widget_catalog_data
                conf =[
                'context'   =>  'product-gallery'
                ]
                assign='galeryProductData'
            }
            {if $galeryProductData != null}
            <div id="product-gallery">
                {* Example widget_catalog_display for gallery
                {widget_product_gallery
                    title= "<h2>{#gallery#|ucfirst}</h2>"
                }
                *}

                <h2>{#gallery#|ucfirst}</h2>
                {include file="catalog/loop/gallery.tpl" data=$galeryProductData}
            </div>
            {/if}
        </div>
        <div class="col-xs12 col-md-8">
            {$product.content}
            {* Example widget_catalog_display for similar_products
            {widget_catalog_display
            title   =   "<h2>{#similar_products#|ucfirst}</h2>"
            pattern =   [
                'item' => [
                    'before'    =>  '<div class="thumbnail col-sm-6">',
                    'after'     =>  '</div></div>'
                ]
            ]
            }*}
            {widget_catalog_data
                assign='productRel'
            }
            {if $productRel != null}
            <h2>{#similar_products#|ucfirst}</h2>
            {$classCat =  "thumbcat-{$cat.id}"}
            <div id="listing-product" class="product-list">
                {include file="catalog/loop/product.tpl" data=$productRel classCat=$classCat}
            </div>
            {/if}
        </div>
    </div>
{/block}