{strip}
    {if !isset($dir)}
        {assign var="dir" value="down"}
    {/if}
    {if !isset($align)}
        {assign var="align" value="left"}
    {/if}
    {if !isset($shareData)}
        {widget_share_data assign="shareData"}
    {/if}
    {* Share tools *}
{*<div class="share">
    <ul class="nav nav-justified share-nav">
        {include file="section/loop/share.tpl" data=$shareData}
    </ul>
</div>*}
{*<div id="share" class="navbar-collapse collapse share-box pull-right col-md-4">
    <ul class="list-inline">
        {include file="section/loop/share.tpl" data=$shareData}
    </ul>
</div>*}
{/strip}
<div class="drop{$dir} pull-{$align}">
    <button class="btn btn-flat btn-main-theme dropdown-toggle" type="button" id="menu-share" data-toggle="dropdown" {*aria-haspopup="true" aria-expanded="true"*}>
        <span class="fa fa-share-alt"></span>
        {#share#|ucfirst}
    </button>
    <ul class="list-unstyled share-nav" aria-labelledby="menu-share">
        {include file="section/loop/share.tpl" data=$shareData}
    </ul>
</div>