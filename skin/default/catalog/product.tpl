{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'3','idmetas'=>'2','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}}
    <title>{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$product.name] category=$cat.name subcategory=$subcat.name record=$product.name}</title>
{include file="section/css.tpl"}
</head>
<body id="product">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{$product.name}</h1>
                <div id="product-info" class="span3 pull-right img-polaroid">
                    {if $product.imgSrc.medium}
                        <a href="{$product.imgSrc.large}" class="img-zoom" title="{#zoom_in#|ucfirst}">
                            <img src="{$product.imgSrc.medium}" alt="{$product.name}" />
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
                {$product.content}
                <div id="product-gallery">
                    {widget_product_gallery
                        title= "<h2>{#gallery#|ucfirst}</h2>"
                    }
                 </div>
                {widget_catalog_display
                    title   =   "<h2>{#similar_products#|ucfirst}</h2>"
                    pattern =   'product'
                }
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
</body>
</html>