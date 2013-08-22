{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>$cat.name] category=$cat.name}}
    <title>{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>$cat.name]  category=$cat.name}</title>
{include file="section/css.tpl"}
</head>
<body id="catalog-cat">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{$cat.name}</h1>
                {$cat.content}
                {widget_catalog_display}
                {widget_catalog_display
                    conf =[
                    'context' =>  'product'
                    ]
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