{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'1','idmetas'=>'2','default'=>#seo_t_static_news#] category=$tag.name}}
<title>{seo_rewrite config_param=['level'=>'1','idmetas'=>'1','default'=>#seo_t_static_news#] category=$tag.name}</title>
{include file="section/css.tpl"}
</head>
<body id="news-tag">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
            <h1>{$tag.name|ucfirst}</h1>
                {widget_news_display}
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
</body>
</html>