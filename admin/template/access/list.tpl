{extends file="layout.tpl"}
{block name='body:id'}module-user{/block}
{block name="article:content"}
    <h1>{#h1_access_list#}</h1>
    <p>
        <a class="btn btn-primary" href="#" id="open-add">
            <span class="fa fa-plus"></span> {#add_role#}
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    <div id="load_json_profiles"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="{#add_role#}">
        {include file="access/forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="access/section/js.tpl"}
{/block}