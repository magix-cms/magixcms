{extends file="layout.tpl"}
{block name='body:id'}module-user{/block}
{block name="article:content"}
    {include file="user/section/nav.tpl"}
    <h1>Statistiques des utilisateurs</h1>
    <div id="graph"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
{include file="user/section/js.tpl"}
{/block}