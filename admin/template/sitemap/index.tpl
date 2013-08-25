{extends file="layout.tpl"}
{block name='body:id'}module-googletools{/block}
{block name="article:content"}
    <h1>Sitemap</h1>
    <div class="mc-message clearfix"></div>
    {include file="sitemap/forms/add.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="sitemap/section/js.tpl"}
{/block}