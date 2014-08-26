{extends file="layout.tpl"}
{block name='body:id'}module-catalog{/block}
{block name="article:content"}
{include file="catalog/section/nav.tpl"}
    <h1>{#editing_the_category#|ucfirst} : {$clibelle}</h1>
    {if $access.edit eq 1}
    <ul class="nav nav-tabs clearfix">
        <li{if !$smarty.get.tab && !$smarty.get.plugin} class="active"{/if}>
            <a href="/{baseadmin}/catalog.php?section={$smarty.get.section}&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}">{#text#|ucfirst}</a>
        </li>
        <li{if $smarty.get.tab eq "image"} class="active"{/if}>
            <a href="/{baseadmin}/catalog.php?section={$smarty.get.section}&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;tab=image">Image</a>
        </li>
        <li{if $smarty.get.tab eq "subcat"} class="active"{/if}>
            <a href="/{baseadmin}/catalog.php?section={$smarty.get.section}&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;tab=subcat">{#subcategory#|ucfirst}</a>
        </li>
        <li{if $smarty.get.tab eq "product"} class="active"{/if}>
            <a href="/{baseadmin}/catalog.php?section={$smarty.get.section}&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;tab=product">{#products#|ucfirst}</a>
        </li>
        </li>
        {if $plugin != null}
            {foreach $plugin as $key}
                <li{if $smarty.get.plugin eq $key.url} class="active"{/if}>
                    <a href="/{baseadmin}/catalog.php?section={$smarty.get.section}&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;plugin={$key.url}">{$key.name|ucfirst}</a>
                </li>
            {/foreach}
        {/if}
    </ul>
    <div class="mc-message clearfix"></div>
    {include file="catalog/category/forms/edit.tpl"}
    {else}
        <div class="mc-message clearfix">
            <div class="alert alert-danger">
                <span class="fa fa-warning"></span> {#request_access_denied#}
            </div>
        </div>
    {/if}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
    {if $smarty.get.tab eq "subcat"}
        <div id="forms-add" class="hide-modal" title="{#add_a_subcategory#|ucfirst}">
            {include file="catalog/subcategory/forms/add.tpl"}
        </div>
    {else}
        <div id="forms-add" class="hide-modal" title="{#add_a_category#|ucfirst}">
            {include file="catalog/category/forms/add.tpl"}
        </div>
    {/if}
{/block}
{block name='javascript'}
    {include file="catalog/section/js.tpl"}
{/block}