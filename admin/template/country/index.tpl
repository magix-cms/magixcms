{extends file="layout.tpl"}
{block name='body:id'}module-country{/block}
{block name="article:content"}
    <h1>{#country#}</h1>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="lang/section/js.tpl"}
{/block}