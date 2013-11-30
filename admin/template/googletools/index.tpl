{extends file="layout.tpl"}
{block name='body:id'}module-googletools{/block}
{block name="article:content"}
    <h1>Google Tools</h1>
    <div class="mc-message clearfix"></div>
    {include file="googletools/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="googletools/section/js.tpl"}
{/block}