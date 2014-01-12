{extends file="layout.tpl"}
{block name='body:id'}module-language{/block}
{block name="article:content"}
    {include file="lang/section/nav.tpl"}
    <h1>{#list_of_language#|ucfirst}</h1>
    <p>
        <a class="btn btn-primary" href="#" id="open-add">
            <span class="fa fa-plus"></span> {#add_a_language#|ucfirst}
        </a>
    </p>
    <div class="mc-message clearfix"></div>
    <div id="list_lang"></div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    <div id="forms-add" class="hide-modal" title="{#add_a_language#|ucfirst}">
        {include file="lang/forms/add.tpl"}
    </div>
{/block}
{block name='javascript'}
    {include file="lang/section/js.tpl"}
{/block}