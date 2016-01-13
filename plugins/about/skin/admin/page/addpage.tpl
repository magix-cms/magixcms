{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>

    {include file="page/form/addchild.tpl"}
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}