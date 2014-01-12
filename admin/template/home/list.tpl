{extends file="layout.tpl"}
{block name='body:id'}module-home{/block}
{block name="article:content"}
{include file="home/section/nav.tpl"}
<h1>{#list_of_homepages#|ucfirst}</h1>
<p>
    <a class="btn btn-primary" href="#" id="open-add">
        <span class="fa fa-plus"></span> {#add_a_page#|ucfirst}
    </a>
</p>
<div class="mc-message clearfix"></div>
<div id="list_home"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="{#add_a_new_page#|ucfirst}">
        {include file="home/forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="home/section/js.tpl"}
{/block}