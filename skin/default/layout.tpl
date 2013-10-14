{autoload_i18n}<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="{getlang}" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="{getlang}" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="{getlang}" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="{getlang}" > <!--<![endif]-->
<head>
    {* Document meta *}
    <meta charset="utf-8">
    <title>{block name="title"}{/block}</title>
    <meta name="description" content="{block name="description"}{/block}">
    <meta name="robots" content="{google_tools tools='robots'}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {if $googleTools_webmaster != '' }
        <meta name="google-site-verification" content="{$googleTools_webmaster}">
    {/if}
    <link rel="icon" type="image/png" href="{geturl}/skin/{template}/img/favicon.png" />
    <!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="{geturl}/skin/{template}/img/favicon.ico" /><![endif]-->
    {block name="styleSheet"}
        <link rel="stylesheet" href="/min/?f=skin/{template}/css/bootstrap/bootstrap.css,skin/{template}/css/fancybox/jquery.fancybox.css,skin/{template}/css/main.css"/>
    {/block}
    {if {module type="news"} eq true}
        <link rel="alternate" type="application/rss+xml" href="{geturl}/rss.xml" title="RSS">
    {/if}
    {capture name="scriptHtml5"}{strip}
        /min/?f=
        skin/{template}/js/vendor/html5shiv.js,
        skin/{template}/js/vendor/respond.min.js
    {/strip}{/capture}
    <!--[if lt IE 9]>
        {script src=$smarty.capture.scriptHtml5 concat=$concat type="javascript"}
    <![endif]-->
    {google_tools tools='analytics'}
</head>
<body id="{block name='body:id'}layout{/block}">
        <header id="header">
            {include file="section/header.tpl"}
        </header>

        {include file="section/breadcrumb.tpl"}

        <main id="content" class="container">
            {block name="main:before"}

            {/block}
                {block name='article'}
                    <article id="article" class="col-sm-8 col-md-9 pull-left">
                        {block name='article:content'}
                        {/block}
                    </article>
                {/block}
                {block name="aside"}
                    <aside id="aside" class="col-sm-4 col-md-3 pull-left">
                        <div class="well">
                            {block name='aside:content'}
                                {include file="section/sidebar.tpl"}
                            {/block}
                        </div>
                    </aside>
                {/block}
            {block name="main:after"}
            {/block}
        </main>

        <footer id="footer" class="container well">
            {include file="section/footer.tpl"}
        </footer>

        {block name="foot"}
        {*  Magix Js
            ********}
            {script src="/min/?g=publicjs,jimagine" concat=$concat type="javascript"}
        {*  Vendor Js
            ********}
            {capture name="scriptVendor"}{strip}
                /min/?f=
                skin/{template}/js/vendor/bootstrap.js,
                skin/{template}/js/vendor/jquery.fancybox.min.js
            {/strip}{/capture}
            {script src=$smarty.capture.scriptVendor concat=$concat type="javascript"}
        {*  Skin js
            *******}
            {capture name="scriptSkin"}{strip}
                /min/?f=
                skin/{template}/js/form.js,
                skin/{template}/js/global.js
            {/strip}{/capture}
            {script src=$smarty.capture.scriptSkin concat=$concat type="javascript"}
        {/block}
</body>
</html>
