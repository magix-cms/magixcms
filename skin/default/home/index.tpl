{include file="section/head.tpl"}
{if {google_tools tools='webmaster'} != ''}{headmeta meta="googleSiteVerification" content="{google_tools tools='webmaster'}"}{/if}
{headmeta meta="description" content="{static_metas param='' dynamic=$home.seoDescr}"}
<title>{static_metas param='' dynamic=$home.seoTitle}</title>
{include file="section/css.tpl"}
</head>
<body id="home">
<div id="page" class="container">
{include file="section/header.tpl"}
    <div id="content" class="row">
    {include file="section/sidebar.tpl"}
        <div id="article" class="span9">
            <div id="article-inner" class="span8">
                <h1>{$home.name}</h1>
                {$home.content}
                {widget_cms_display
                    conf = [
                        'context' => 'parent'
                    ]
                }
            </div>
        </div>
    </div>
{include file="section/footer.tpl"}
</div>
{include file="section/foot.tpl"}
</body>
</html>