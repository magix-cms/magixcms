{extends file="layout.tpl"}
{block name='body:id'}module-catalog{/block}
{block name="article:content"}
    {include file="catalog/section/nav.tpl"}
        <h1>{#statistics_catalog#}</h1>
        <div id="graph"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="catalog/section/js.tpl"}
{/block}