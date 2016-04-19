{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <h1>Contact</h1>
    {include file="section/tab.tpl"}
    <h2>Configuration</h2>
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>
    <!-- Tab panes -->
    <div>
        <form id="enable_address_form" class="form-inline" method="post" action="{$smarty.server.REQUEST_URI}">
            <div class="checkbox">
                <label>
                    Champs adresse
                    <input id="enable_address" data-toggle="toggle" type="checkbox" name="enable_address" data-on="oui" data-off="non"{if $config.address_enabled} checked{/if}>
                </label>
            </div>
            <input type="hidden" name="switch" value="enable">
        </form>
        <form id="require_address_form" class="form-inline" method="post" action="{$smarty.server.REQUEST_URI}">
            <div class="checkbox">
                <label>
                    Champs requis
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