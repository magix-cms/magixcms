{extends file="layout.tpl"}
{block name='body:id'}module-user{/block}
{block name="article:content"}
    <h1>{#h1_access_list#}</h1>
    <div class="mc-message clearfix"></div>
    <div class="col-md-5">
        {include file="access/forms/edit.tpl"}
        {include file="access/forms/access.tpl"}
    </div>
    <div class="col-md-7">
        <h3>{#change_access#}</h3>
        <div id="load_json_access"></div>
    </div>
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