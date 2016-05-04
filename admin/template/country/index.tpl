{extends file="layout.tpl"}
{block name='body:id'}module-country{/block}
{block name="article:content"}
    {include file="country/section/nav.tpl"}
    <h1>{#country#}</h1>
    <p class="btn-row">
        <a class="btn btn-primary" href="#" id="open-add-country" data-toggle="modal" data-target="#add-country">
            <span class="fa fa-plus"></span> Ajouter un pays
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    <div id="country-items">
        {include file="country/loop/items.tpl"}
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    {include file="country/modal/add.tpl"}
    {include file="country/modal/delete.tpl"}
{/block}
{block name='javascript'}
    {include file="country/section/js.tpl"}
{/block}