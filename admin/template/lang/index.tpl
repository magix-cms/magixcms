{extends file="layout.tpl"}
{block name='body:id'}module-language{/block}
{block name="article:content"}
{include file="lang/section/nav.tpl"}
    <h1>{#statistics_language#|ucfirst}</h1>
    <div id="graph"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="lang/section/js.tpl"}
{/block}