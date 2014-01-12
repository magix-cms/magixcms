{extends file="layout.tpl"}
{block name='body:id'}module-user{/block}
{block name="article:content"}
    {include file="user/section/nav.tpl"}
    <h1>{#h1_user_list#}</h1>
    <p>
        <a class="btn btn-primary" href="#" id="open-add">
            <span class="fa fa-plus"></span> {#add_user#}
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    <div id="list_user"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="Ajouter un utilisateur">
        {include file="user/forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="user/section/js.tpl"}
{/block}