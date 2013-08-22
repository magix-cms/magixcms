{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content={seo_rewrite config_param=['level'=>'3','idmetas'=>'2','default'=>$news.name] record=$news.name}}
<title>{seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>$news.name] record=$news.name}</title>
{include file="section/css.tpl"}
</head>
<body id="news-record">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{$news.name}</h1>
                <small>
                    {#published_on#|ucfirst} {$news.date.register|date_format:"%d-%m-%Y"}
                    {if $news.date.publish|date_format:"%d-%m-%Y" != $news.date.register|date_format:"%d-%m-%Y"}
                        {#updated_on#} {$news.date.publish|date_format:"%d-%m-%Y"}
                    {/if}
                </small>
                {if $news.imgSrc.small}
                    <a href="{$news.imgSrc.medium}" class="img-zoom" title="{#zoom_in#}">
                        <img src="{$news.imgSrc.small}" alt="{$news.name}" class="pull-right img-polaroid" />
                    </a>
                {/if}
                {$news.content}
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
</body>
</html>