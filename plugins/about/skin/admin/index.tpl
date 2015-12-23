{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    {include file="tabs.tpl"}
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="info_company">
            {include file="form/company.tpl"}
        </div>
        <div role="tabpanel" class="tab-pane" id="info_contact">
            {include file="form/contact.tpl"}
        </div>
        <div role="tabpanel" class="tab-pane" id="info_socials">
            {include file="form/socials.tpl"}
        </div>
        <div role="tabpanel" class="tab-pane" id="info_opening">
            {include file="form/openinghours.tpl"}
        </div>
    </div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}