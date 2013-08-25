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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/install/template/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/install/template/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/install/template/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/install/template/img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="icon" type="image/png" href="/install/template/img/favicon.png" />
    <!--[if IE]>
    <link rel="shortcut icon" type="image/x-icon" href="/install/template/img/favicon.ico" />
    <![endif]-->
    {block name="styleSheet"}
    {capture name="styleSheet"}/min/?f=install/template/css/bootstrap.3.0.0.min.css,install/template/css/font-awesome.css,install/template/css/style.css{/capture}
    {capture name="styleSheetIe"}/min/?f=install/template/css/font-awesome-ie7.min.css{/capture}
    {headlink rel="stylesheet" href=$smarty.capture.styleSheet concat={$concat} media="screen"}
    <!--[if IE 7]>
    {headlink rel="stylesheet" href=$smarty.capture.styleSheetIe concat={$concat} media="screen"}
    <![endif]-->
    {/block}
    {headmeta meta="description" content="Magix CMS | Install"}
    <title>Magix CMS | Install</title>
</head>
<body id="{block name='body:id'}layout{/block}" class="install">
    <div class="container-narrow">
    {* Header *}
    <header>
        {include file="section/top.tpl"}
    </header>
    {block name="main:before"}{/block}
    <main id="main" class="container">
        {block name="main:breadcrumb"}
        {function name=breadcrumb active=''}
            <ul class="breadcrumb">
                {foreach $data as $key => $value nocache}
                    <li>
                        <a href="/install/{$key}">{$value}</a>
                    </li>
                {/foreach}
                {if $active != ''}
                    <li>
                        <span class="active">{$active}</span>
                    </li>
                {/if}
            </ul>
        {/function}
        {/block}
        {block name='main:content'}
        {/block}
        {block name="main:pager"}
        {/block}
    </main>
    {block name="main:after"}{/block}
    {include file="section/footer.tpl"}
    </div>
{include file="section/js.tpl"}
{block name='javascript'}{/block}
</body>
</html>