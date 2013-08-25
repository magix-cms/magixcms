{extends file="layout.tpl"}
{block name='body:id'}module-config{/block}
{block name="article:content"}
{include file="config/section/nav.tpl"}
<h1>Configuration</h1>
<div class="mc-message clearfix"></div>
{include file="config/forms/config.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="config/section/js.tpl"}
{/block}