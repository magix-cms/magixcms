{extends file="layout.tpl"}
{block name='body:id'}module-pages{/block}
{block name="article:content"}
{include file="cms/section/nav.tpl"}
    <h1>{#move_page#|ucfirst} : {$title_page}</h1>
    <div class="mc-message clearfix"></div>
    {include file="cms/forms/move.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="cms/section/js.tpl"}
{/block}