{include file="section/head.tpl" section="prepend"}
{headmeta meta="description" content="{cms_seo config_param=['seo'=>$page.seoDescr,'default'=>$page.name]}"}
<title>{cms_seo config_param=['seo'=>$page.seoTitle,'default'=>$page.name]}</title>
{include file="section/css.tpl"}
</head>
<body id="cms">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{$page.name}</h1>
                <p>
                    <small>
                        Publié le {$page.date.register}
                        {if $page.date.update}
                        , mis à jour le {$page.date.update}
                        {/if}
                    </small>
                </p>
                {$page.content}
            </div>
        </div>
        </div>
    {include file="section/footer.tpl"}
    </div>
{include file="section/foot.tpl"}
</body>
</html>