{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'2','idmetas'=>'2','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}}
    <title>{seo_rewrite config_param=['level'=>'2','idmetas'=>'1','default'=>$subcat.name] category=$cat.name subcategory=$subcat.name}</title>
{include file="section/css.tpl"}
</head>
<body id="catalog-subcat">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{$subcat.name}</h1>
                {$subcat.content}
                {widget_catalog_display
                    pattern = 'product'
            }
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
</body>
</html>