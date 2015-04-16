{autoload_i18n}{doctype type="HTML5"}
<!--[if lt IE 7]> <html lang="{iso}" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="{iso}" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="{iso}" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="{iso}" > <!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    {headmeta meta="contentType" content="html" charset="utf8"}
    <meta name="dcterms.language" content="{iso}" />
    <meta name="dcterms.creator" content="Magix CMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {headmeta meta="keywords" content=""}
    {headmeta meta="robots" content="noindex,nofollow"}
    <link rel="icon" type="image/png" href="/{baseadmin}/template/img/favicon.png" />
    <!--[if IE]>
    <link rel="shortcut icon" type="image/x-icon" href="/{baseadmin}/template/img/favicon.ico" />
    <![endif]-->
{block name="styleSheet"}
    {capture name="styleSheet"}/{baseadmin}/min/?g=css{/capture}
    {capture name="styleSheetIe"}{strip}
     /{baseadmin}/min/?f={baseadmin}/template/css/ui-bootstrap/jquery.ui.1.10.3.ie.css
    {/strip}{/capture}
    {headlink rel="stylesheet" href=$smarty.capture.styleSheet concat={$concat} media="screen"}
    <!--[if IE 7]>
    {headlink rel="stylesheet" href=$smarty.capture.styleSheetIe concat={$concat} media="screen"}
    <![endif]-->
{/block}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    {capture name="scriptHtml5"}{strip}
    /{baseadmin}/min/?f=
    libjs/html5shiv.js,
    libjs/respond.min.js
    {/strip}{/capture}
    <!--[if lt IE 9]>
        {script src=$smarty.capture.scriptHtml5 concat=$concat type="javascript"}
    <![endif]-->
    {block name="install"}
    {/block}
    {headmeta meta="description" content="Magix CMS | Admin"}
    <title>Magix CMS | Admin</title>
</head>
<body id="{block name='body:id'}layout{/block}">
{block name="body:container"}
{* Header *}
<header>
    {include file="section/top.tpl"}
</header>
{block name="main"}
<main id="main" class="container">
    {block name="main:before"}{/block}
    {function cleanTextarea}
        {$field|escape:'html':'UTF-8':TRUE}
    {/function}
    {block name="aside"}
        <aside id="sidebar" class="col-md-2 col-sm-3 col-xs-12 pull-left">
            {block name='aside:content'}
                {include file="section/sidebar.tpl"}
            {/block}
        </aside>
    {/block}
    {block name='article'}
        <article id="article" class="col-md-10 col-sm-9 col-xs-12 pull-left">
            {block name='article:content'}
            {/block}
        </article>
    {/block}
    {block name="main:after"}{/block}
</main>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{* Footer *}
{include file="section/footer.tpl"}
{include file="section/js.tpl"}
{* javascript *}
{block name='javascript'}{/block}
{/block}
</body>
</html>