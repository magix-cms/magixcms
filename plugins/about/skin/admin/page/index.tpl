{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>{#page_root#|ucfirst}</h1>
    <p>
        <a class="toggleModal btn btn-primary" data-toggle="modal" data-target="#add-page" href="#">
            <span class="fa fa-plus"></span>
            {#add_page#|ucfirst}
        </a>
    </p>
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>

    <div id="list-page">
        {include file="page/loop/home-list.tpl"}
    </div>
    {include file="page/modal/addpage.tpl"}
    {include file="page/modal/delete.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}