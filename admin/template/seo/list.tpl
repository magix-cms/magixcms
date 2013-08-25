{extends file="layout.tpl"}
{block name='body:id'}module-seo{/block}
{block name="article:content"}
    {include file="seo/section/nav.tpl"}
    <h1>{#h1_listing_rewriting#}</h1>
    <div class="mc-message clearfix"></div>
    {include file="seo/forms/add.tpl"}
    <div id="list_seo"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="seo/section/js.tpl"}
{/block}