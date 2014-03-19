{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    <h1>Traduction statique</h1>
    {include file="section/tab.tpl"}
    <h2>Core</h2>
    <p>
        <a class="btn btn-default" href="/{baseadmin}/plugins.php?name=translation&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;section=core">
            <span class="fa fa-file-text-o"></span> Local
        </a>
    </p>
    <h2>Plugins</h2>
    <ul class="list-inline">
    {foreach $array_plugin_i18n as $key => $value nocache}
    <li>
        <a class="btn btn-default" href="/{baseadmin}/plugins.php?name=translation&amp;getlang={$smarty.get.getlang}&amp;action=edit&amp;section=plugin&amp;pluginame={$value}">
        {$value}
        </a>
    </li>
    {/foreach}
    </ul>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}