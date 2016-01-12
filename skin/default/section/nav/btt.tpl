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
<div{if $affix != 'none'} data-spy="affix" data-offset-top="{$affix}"{/if} class="align-{$align} toTop{if $affix == 'none'} float-btn{/if}">
    <a{if $btn} class="btn btn-flat btn-main-theme"{/if} href="#"{if !$btn} data-toggle="tooltip" data-placement="bottom"{/if} title="{#back_to_top#|ucfirst}">
        <span class="fa fa-angle-up"></span>
    </a>
</div>