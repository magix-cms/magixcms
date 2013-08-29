{autoload_i18n}<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html lang="{getlang}" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{getlang}" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{getlang}" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{getlang}" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{getlang}"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
{*    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> *}
    <base href="{geturl}/" />
    <meta name="dcterms.language" content="{getlang}" />
    <meta name="dcterms.creator" content="magix-cms.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {headmeta meta="robots" content={google_tools tools='robots'}}
    {headmeta meta="keywords" content=""}
    {if {module type="news"} eq true}
        {headlink rel="rss" href="{geturl}/news_{getlang}_rss.xml"}
    {/if}
	<link rel="icon" type="image/png" href="{geturl}/skin/{template}/img/favicon.png" />
	<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="{geturl}/skin/{template}/img/favicon.ico" /><![endif]-->
    <!--[if lt IE 9]>
       <script type="text/javascript" src="/skin/{template}/js/plugins/iepp.min.js"></script>
    <![endif]-->
    {google_tools tools='analytics'}