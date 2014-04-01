{extends file="layout.tpl"}
{block name='body:id'}module-home{/block}
{block name="article:content"}
    {include file="home/section/nav.tpl"}
    <h1>{#editing_the_page#|ucfirst} : {$subject}</h1>
    {if $access.edit eq 1}
        <div class="mc-message clearfix"></div>
    {include file="home/forms/edit.tpl"}
    {else}
        <div class="mc-message clearfix">
            <div class="alert alert-danger">
                <span class="fa fa-warning"></span> {#request_acces_denied#}
            </div>
        </div>
    {/if}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="home/section/js.tpl"}
{/block}