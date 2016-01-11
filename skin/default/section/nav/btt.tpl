{strip}
    {if !isset($align)}
        {assign var="align" value="right"}
    {/if}
    {if !isset($affix)}
        {assign var="affix" value="0"}
    {/if}
    {if !isset($btn)}
        {assign var="btn" value=false}
    {/if}
{/strip}
<div{if $affix != 'none'} data-spy="affix" data-offset-top="{$affix}"{/if} class="pull-right toTop">
    <a{if $btn} class="btn btn-flat btn-main-theme"{/if} href="#" title="{#back_to_top#}">
        <span class="fa fa-angle-up"></span>
    </a>
</div>