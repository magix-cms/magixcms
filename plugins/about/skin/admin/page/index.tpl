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

    <table class="table table-bordered table-condensed table-hover">
        <thead>
        <tr>
            <th><span class="fa fa-key"></span></th>
            <th>{#page_title#|ucfirst}</th>
            <th>{#page_content#|ucfirst}</th>
            <th>{#page_seo_title#|ucfirst}</th>
            <th>{#page_seo_desc#|ucfirst}</th>
            <th><span class="fa fa-users"></span></th>
            <th><span class="fa fa-edit"></span></th>
            <th><span class="fa fa-trash-o"></span></th>
        </tr>
        </thead>
        <tbody id="list_page">
        {if !empty($pages)}
            {include file="page/loop/list.tpl" pages=$pages}
        {/if}
        {include file="page/no-entry.tpl"}
        </tbody>
    </table>
    {include file="page/modal/addpage.tpl"}
    {include file="page/modal/delete.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}