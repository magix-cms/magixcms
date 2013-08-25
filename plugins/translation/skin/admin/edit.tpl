{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    <h1>Traduction statique</h1>
    {include file="section/tab.tpl"}
    <h2>Edition du fichier : {$smarty.get.tab} {if $smarty.get.plugin}{$smarty.get.plugin}{/if}</h2>
    <div class="mc-message clearfix"></div>
    {include file="forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}