{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>{$pluginName} Plugin <small>- {#plugin_about#}</small></h1>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            {$pluginInfo}
        </div>
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}