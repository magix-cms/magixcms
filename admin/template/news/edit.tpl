{extends file="layout.tpl"}
{block name='body:id'}module-language{/block}
{block name="article:content"}
{include file="news/section/nav.tpl"}
    <div class="row">
        <span class="col-sm-10">
            <h1>{#editing_the_page#|ucfirst} : {$n_title}</h1>
        </span>
        <span class="col-sm-2">
            <a class="btn btn-primary btn-large post-preview" href="#">
                <span class="icon-zoom-in"></span>
            </a>
        </span>
    </div>
    <ul class="nav nav-tabs clearfix">
        <li{if !$smarty.get.tab} class="active"{/if}>
            <a href="/admin/news.php?getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}">{#text#|ucfirst}</a>
        </li>
        <li{if $smarty.get.tab eq "image"} class="active"{/if}>
            <a href="/admin/news.php?getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;tab=image">Image</a>
        </li>
        <li{if $smarty.get.tab eq "tags"} class="active"{/if}>
            <a href="/admin/news.php?getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;tab=tags">Tags</a>
        </li>
    </ul>
    <div class="mc-message clearfix"></div>
    {include file="news/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="news/section/js.tpl"}
{/block}