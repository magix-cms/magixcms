{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>{#topmenu_catalog_t#}]}}
<title>{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>{#topmenu_catalog_t#}]}</title>
{include file="section/css.tpl"}
</head>
<body id="catalog-root">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{#catalog_root_h1#}</h1>
                {widget_catalog_display}
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
</body>
</html>