{extends file="layout.tpl"}
{block name='body:id'}module-pages{/block}
{block name="article:content"}
{include file="cms/section/nav.tpl"}
<div class="row">
    <span class="col-sm-10">
    <h1>{#editing_the_page#|ucfirst} : {$title_page}</h1>
    </span>
    <span class="col-sm-2">
        <a class="btn btn-primary btn-large post-preview" href="#">
            <span class="fa fa-search-plus"></span>
        </a>
    </span>
</div>
<div class="mc-message clearfix"></div>
{include file="cms/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="cms/section/js.tpl"}
{/block}