{extends file="layout.tpl"}
{block name='body:id'}module-theming{/block}
{block name="article:content"}
    {include file="theming/section/nav.tpl"}
    <h1>{#template_management#|ucfirst}</h1>
    <div class="mc-message clearfix"></div>
    <div id="theming">
        {include file="theming/req.tpl"}
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="theming/section/js.tpl"}
{/block}