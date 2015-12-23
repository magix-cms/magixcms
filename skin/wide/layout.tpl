{autoload_i18n}{widget_about_data}<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="{getlang}" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="{getlang}" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="{getlang}" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="{getlang}" > <!--<![endif]-->
<head {block name="ogp"}{include file="section/brick/ogp-protocol.tpl"}{/block}>
    {* Document meta *}
    <meta charset="utf-8">
    <title>{capture name="title"}{block name="title"}{/block}{/capture}{$smarty.capture.title}</title>
    <meta name="description" content="{capture name="description"}{block name="description"}{/block}{/capture}{$smarty.capture.description}">
    <meta name="robots" content="{google_tools tools='robots'}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {block name="socials"}{include file="section/brick/socials.tpl" title=$smarty.capture.title description=$smarty.capture.description}{/block}
    {if $googleTools_webmaster != '' }
        <meta name="google-site-verification" content="{$googleTools_webmaster}">
    {/if}
    <link rel="icon" type="image/png" href="{geturl}/skin/{template}/img/favicon.png" />
    <!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="{geturl}/skin/{template}/img/favicon.ico" /><![endif]-->
    {include file="section/brick/criticalcss.tpl"}
    {if {module type="news"} eq true}
    <link rel="alternate" type="application/rss+xml" href="{geturl}/news_{getlang}_rss.xml" title="RSS">
    {/if}
    {capture name="scriptHtml5"}{strip}
        /min/?f=
        skin/{template}/js/vendor/html5shiv.js,
        skin/{template}/js/vendor/respond.min.js
    {/strip}{/capture}
    <!--[if lt IE 9]>
        {script src=$smarty.capture.scriptHtml5 concat=$concat type="javascript"}
    <![endif]-->
    {* Language link hreflang *}
    {widget_lang_data assign="dataLangHead"}
    {include file="section/loop/lang.tpl" data=$dataLangHead type="head"}
    {google_tools tools='analytics'}
</head>
<body itemscope itemtype="http://schema.org/{$companyData.type}" id="{block name='body:id'}layout{/block}">

    {include file="section/toolbar.tpl" adjust="clip"}

    {include file="section/header.tpl" adjust="clip"}

    {block name="breadcrumb"}
        {include file="section/nav/breadcrumb.tpl"}
    {/block}

    {block name="main:before"}{/block}

    {block name="main"}
    <main id="content" class="container">
        <div class="row">
            {block name="article:before"}{/block}

            {block name='article'}
                <article id="article">
                    {block name='article:content'}{/block}
                </article>
            {/block}

            {block name="article:after"}{/block}
            </div>
    </main>
    {/block}

    {block name="main:after"}{/block}

    {include file="section/footer.tpl" adjust="clip"}

    {include file="section/nav/btt.tpl"}

    {block name="foot"}
    {*  Magix Js
        ********}
        {script src="/min/?g=publicjs,jimagine" concat=$concat type="javascript"}
    {*  Vendor Js
        ********}
        {capture name="scriptVendor"}{strip}
            /min/?f=
            skin/{template}/js/vendor/bootstrap.min.js,
            skin/{template}/js/vendor/jquery.fancybox.min.js
        {/strip}{/capture}
        {script src=$smarty.capture.scriptVendor concat=$concat type="javascript"}
    {*  Skin js
        *******}
        {capture name="scriptSkin"}{strip}
            /min/?f=
            skin/{template}/js/form.min.js,
            skin/{template}/js/global.min.js
        {/strip}{/capture}
        {script src=$smarty.capture.scriptSkin concat=$concat type="javascript"}
    {/block}
</body>
</html>
{block name="fonts"}{include file="section/brick/google-font.tpl" fonts=['Open Sans'=>'300,400,600,400italic','Raleway'=>'300','Philosopher'=>'0']}{/block}
{block name="styleSheet"}
    {capture name="styleSheet"}{strip}
        /min/?f=skin/{template}/css/bootstrap/bootstrap.min.css,
        skin/{template}/css/fancybox/jquery.fancybox.min.css
    {/strip}{/capture}
    {headlink rel="stylesheet" href=$smarty.capture.styleSheet concat=$concat media="screen"}
{/block}
