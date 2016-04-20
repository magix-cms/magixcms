{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>Contact&nbsp;<small>&mdash;&nbsp;Configuration</small></h1>
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>
    <!-- Tab panes -->
    <h2>Champs personnalisés</h2>
    <div class="row">
        <form id="enable_address_form" class="form-inline col-xs-12 col-sm-4 col-md-3" method="post" action="{$smarty.server.REQUEST_URI}">
            <div class="checkbox">
                <label>
                    Champs adresse
                    <input id="enable_address" data-toggle="toggle" type="checkbox" name="enable_address" data-on="oui" data-off="non"{if $config.address_enabled} checked{/if}>
                </label>
            </div>
            <input type="hidden" name="switch" value="enable">
        </form>
        <form id="require_address_form" class="form-inline col-xs-12 col-sm-4 col-md-3" method="post" action="{$smarty.server.REQUEST_URI}">
            <div class="checkbox">
                <label>
                    &mdash;&nbsp;Requis
                    <input id="require_address" data-toggle="toggle" type="checkbox" name="require_address" data-on="oui" data-off="non"{if $config.address_required} checked{/if}>
                </label>
            </div>
            <input type="hidden" name="switch" value="require">
        </form>
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}