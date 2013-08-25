{extends file="layout.tpl"}
{block name='body:id'}module-home{/block}
{block name="article:content"}
    {include file="home/section/nav.tpl"}
    <h1>{#statistics_homepages#|ucfirst}</h1>
    <div id="graph"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="home/section/js.tpl"}
{/block}