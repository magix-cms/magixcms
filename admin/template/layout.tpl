{autoload_i18n}{doctype type="HTML5"}
<!--[if lt IE 7]> <html lang="{iso}" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="{iso}" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="{iso}" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="{iso}" > <!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    {headmeta meta="contentType" content="html" charset="utf8"}
    <base href="{geturl}/">
    <meta name="dcterms.language" content="{iso}" />
    <meta name="dcterms.creator" content="Magix CMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {headmeta meta="keywords" content=""}
    {headmeta meta="robots" content="noindex,nofollow"}
    <link rel="icon" type="image/png" href="/{baseadmin}/template/img/favicon.png" />
    <!--[if IE]>
    <link rel="shortcut icon" type="image/x-icon" href="/{baseadmin}/template/img/favicon.ico" />
    <![endif]-->
{block name="styleSheet"}
    {capture name="styleSheet"}/{baseadmin}/min/?g=css{/capture}
    {capture name="styleSheetIe"}/{baseadmin}/min/?f={baseadmin}/template/css/font-awesome-ie7.min.css,{baseadmin}/template/css/ui-bootstrap/jquery.ui.1.10.3.ie.css{/capture}
    {headlink rel="stylesheet" href=$smarty.capture.styleSheet concat={$concat} media="screen"}
    <!--[if IE 7]>
    {headlink rel="stylesheet" href=$smarty.capture.styleSheetIe concat={$concat} media="screen"}
    <![endif]-->
{/block}
    {block name="install"}
    {/block}
    {headmeta meta="description" content="Magix CMS | Admin"}
    <title>Magix CMS | Admin</title>
</head>
<body id="{block name='body:id'}layout{/block}">
{* Header *}
<header>
    {include file="section/top.tpl"}
</header>
<div id="main-content" class="container">
    {block name="main:before"}{/block}
    <main id="main" class="row">
        {block name="aside"}
            <aside id="sidebar" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-left well">
                {block name='aside:content'}
                    {include file="section/sidebar.tpl"}
                {/block}
            </aside>
        {/block}
        {block name='article'}
            <article id="article" class="col-lg-9 col-md-9 col-sm-8 pull-left">
                {block name='article:content'}
                {/block}
            </article>
        {/block}
    </main>
    {block name="main:after"}{/block}
</div>
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{* Footer *}
{include file="section/footer.tpl"}
{include file="section/js.tpl"}
{* javascript *}
{block name='javascript'}{/block}
</body>
</html>