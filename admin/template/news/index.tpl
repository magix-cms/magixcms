{extends file="layout.tpl"}
{block name='body:id'}module-language{/block}
{block name="article:content"}
{include file="news/section/nav.tpl"}
    <h1>{#statistics_news#|ucfirst}</h1>
    <div id="graph"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="news/section/js.tpl"}
{/block}