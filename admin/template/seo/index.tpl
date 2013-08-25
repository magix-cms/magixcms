{extends file="layout.tpl"}
{block name='body:id'}module-seo{/block}
{block name="article:content"}
{include file="seo/section/nav.tpl"}
    <h1>{#statistics_rewriting#}</h1>
    <div id="graph"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="seo/section/js.tpl"}
{/block}