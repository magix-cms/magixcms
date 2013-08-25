{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    <h1>Traduction statique</h1>
    {include file="section/tab.tpl"}
    <h2>About</h2>
    <div class="col-sm-6">
        {$pluginInfo}
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}