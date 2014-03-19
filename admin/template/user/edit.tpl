{extends file="layout.tpl"}
{block name='body:id'}module-user{/block}
{block name="article:content"}
{include file="user/section/nav.tpl"}
    <h1>{#editing_user#}({$id_admin})</h1>
    <div class="mc-message clearfix"></div>
    {include file="user/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="user/section/js.tpl"}
{/block}