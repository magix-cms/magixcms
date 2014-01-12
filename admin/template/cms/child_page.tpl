{extends file="layout.tpl"}
{block name='body:id'}module-pages{/block}
{block name="article:content"}
{include file="cms/section/nav.tpl"}
<h1>{#list_of_child_pages#|ucfirst}</h1>
<p>
    <a class="btn btn-primary" href="#" id="open-add">
        <span class="fa fa-plus"></span> {#add_a_page#|ucfirst}
    </a>
</p>
<div id="list_child"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="{#add_a_new_page#|ucfirst}">
        {include file="cms/forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="cms/section/js.tpl"}
{/block}