{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>{#h1_listing_contact#}</h1>
    {include file="section/tab.tpl"}
    <p class="btn-row">
        <a class="btn btn-primary" href="#" id="open-add">
            <span class="fa fa-plus"></span> {#add_contact#}
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    <div id="list_contact"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="Ajouter un contact">
        {include file="forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}