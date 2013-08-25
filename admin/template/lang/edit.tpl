{extends file="layout.tpl"}
{block name='body:id'}module-language{/block}
{block name="article:content"}
{include file="lang/section/nav.tpl"}
    <h1>{#editing_language#|ucfirst} : {$language}</h1>
    <div class="mc-message clearfix"></div>
    {include file="lang/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="lang/section/js.tpl"}
{/block}