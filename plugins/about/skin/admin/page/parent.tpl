{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>{#subpage_root#|ucfirst}</h1>
    <p>
        <a class="toggleModal btn btn-primary" href="{$pluginUrl}&amp;tab=page&amp;action=addchild&amp;parent={$smarty.get.parent}">
            <span class="fa fa-plus"></span>
            {#add_subpage#|ucfirst}
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
            <th><span class="fa fa-edit"></span></th>
            <th><span class="fa fa-trash-o"></span></th>
        </tr>
        </thead>
        <tbody id="list_page">
        {if !empty($pages)}
            {include file="page/loop/list.tpl" pages=$pages child=false}
        {/if}
        {include file="page/no-entry.tpl"}
        </tbody>
    </table>
    {include file="page/modal/delete.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}