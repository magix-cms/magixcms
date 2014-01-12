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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {headmeta meta="keywords" content=""}
    {headmeta meta="robots" content="noindex,nofollow"}
    <link rel="icon" type="image/png" href="/install/template/img/favicon.png" />
    <!--[if IE]>
    <link rel="shortcut icon" type="image/x-icon" href="/install/template/img/favicon.ico" />
    <![endif]-->
    {block name="styleSheet"}
    {capture name="styleSheet"}/min/?f=install/template/css/bootstrap/bootstrap.min.css,install/template/css/font-awesome/font-awesome.min.css,install/template/css/main.css{/capture}
    {headlink rel="stylesheet" href=$smarty.capture.styleSheet concat={$concat} media="screen"}
    {/block}
    {headmeta meta="description" content="Magix CMS | Install"}
    <title>Magix CMS | Install</title>
</head>
<body id="{block name='body:id'}layout{/block}" class="install">
    {block name="page"}
    <div id="page" class="container">
        {* Header *}
        <header class="row">
            {include file="section/top.tpl"}
        </header>
        {block name="main:before"}{/block}
        <main id="content" class="row">
            <article id="article" class="col-sm-12 col-md-12">
            {block name="main:breadcrumb"}
            {function name=breadcrumb active=''}
                <ol class="breadcrumb">
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
                </ol>
            {/function}
            {/block}
            {block name='main:content'}
            {/block}
            {block name="main:pager"}
            {/block}
            </article>
        </main>
        {block name="main:after"}{/block}
        {include file="section/footer.tpl"}
    </div>
    {/block}
{include file="section/js.tpl"}
{block name='javascript'}{/block}
</body>
</html>