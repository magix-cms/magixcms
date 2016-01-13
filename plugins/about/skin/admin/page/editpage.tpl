{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="styleSheet" append}
    {include file="css.tpl"}
{/block}
{block name="article:content"}
    {include file="nav.tpl"}
    <!-- Notifications Messages -->
    <div class="mc-message clearfix"></div>

    {if isset($parent)}
        {include file="page/form/editchild.tpl"}
    {else}
        {include file="page/form/editpage.tpl"}
    {/if}
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}