{extends file="layout.tpl"}
{block name='body:id'}module-catalog{/block}
{block name="article:content"}
{include file="catalog/section/nav.tpl"}
    <h1>{#listing_product#|ucfirst}</h1>
    <p>
        <a class="btn btn-primary" href="#" id="open-add">
            <span class="fa fa-plus"></span> {#add_a_product#|ucfirst}
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    {$pagination}
    <div id="list_catalog_product"></div>
    {$pagination}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="{#add_a_product#|ucfirst}">
        {include file="catalog/product/forms/add.tpl"}
    </div>
    <div id="forms-move" class="hide-modal" title="{#move_a_product#|ucfirst}">
        {include file="catalog/product/forms/move.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="catalog/section/js.tpl"}
{/block}