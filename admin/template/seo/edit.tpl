{extends file="layout.tpl"}
{block name='body:id'}module-seo{/block}
{block name="article:content"}
{include file="seo/section/nav.tpl"}
    <h1>{#h1_editing_rewriting#} : {$attribute|ucfirst} {#level#|ucfirst}({$level})</h1>
    <div class="mc-message clearfix"></div>
    {include file="seo/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="seo/section/js.tpl"}
{/block}