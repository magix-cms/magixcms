{extends file="layout.tpl"}
{block name="install"}
    {$refresh_plugins}
{/block}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    <h1>Plugin {$pluginName|ucfirst}</h1>
    <p class="col-sm-6 alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span class="fa fa-ok"></span> {#request_install_plugin#}
    </p>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
{include file="js.tpl"}
{/block}