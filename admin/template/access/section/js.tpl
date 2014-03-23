{script src="/{baseadmin}/min/?g=charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_access.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_access == "undefined")
    {
        console.log("MC_access is not defined");
    }else{
        {if !$smarty.get.edit}
        MC_access.run(iso,baseadmin);
        {else}
        MC_access.runEdit(iso,baseadmin,edit);
        {/if}
    }
});
</script>