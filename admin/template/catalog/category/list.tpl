{extends file="layout.tpl"}
{block name='body:id'}module-catalog{/block}
{block name="article:content"}
{include file="catalog/section/nav.tpl"}
    <h1>{#listing_category#|ucfirst}</h1>
    <p>
        <a class="btn btn-primary" href="#" id="open-add">
            <span class="fa fa-plus"></span> {#add_a_category#|ucfirst}
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    <div id="list_category"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="{#add_a_category#|ucfirst}">
        {include file="catalog/category/forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="catalog/section/js.tpl"}
{/block}