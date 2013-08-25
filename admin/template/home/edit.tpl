{extends file="layout.tpl"}
{block name='body:id'}module-home{/block}
{block name="article:content"}
    {include file="home/section/nav.tpl"}
    <h1>{#editing_the_page#|ucfirst} : {$subject}</h1>
    <div class="mc-message clearfix"></div>
    {include file="home/forms/edit.tpl"}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="home/section/js.tpl"}
{/block}