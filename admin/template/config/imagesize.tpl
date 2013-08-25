{extends file="layout.tpl"}
{block name='body:id'}module-config{/block}
{block name="article:content"}
{include file="config/section/nav.tpl"}
<h1>{#imagesize#|ucfirst}</h1>
<ul class="nav nav-tabs clearfix">
    <li{if !$smarty.get.tab} class="active"{/if}>
        <a href="/admin/config.php?section=imagesize">{#catalog#|ucfirst}</a>
    </li>
    <li{if $smarty.get.tab eq "news"} class="active"{/if}>
        <a href="/admin/config.php?section=imagesize&amp;tab=news">{#news#|ucfirst}</a>
    </li>
    <li{if $smarty.get.tab eq "plugins"} class="active"{/if}>
        <a href="/admin/config.php?section=imagesize&amp;tab=plugins">Plugins</a>
    </li>
</ul>
<div class="mc-message clearfix"></div>
{include file="config/forms/images.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="config/section/js.tpl"}
{/block}