{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_config.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_config == "undefined")
    {
        console.log("MC_config is not defined");
    }else{
        {if $smarty.get.section}
        {if $smarty.get.section eq 'editor' OR $smarty.get.section eq 'cache'}
            MC_config.runEditor(baseadmin);
        {elseif $smarty.get.section eq 'imagesize'}
            MC_config.runImages(baseadmin);
        {/if}
        {else}
            MC_config.runConfig(baseadmin);
        {/if}
    }
});
</script>