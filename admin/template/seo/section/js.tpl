{script src="/{baseadmin}/min/?g=charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/vendor/jquery.a-tools-1.5.2.min.js,{baseadmin}/template/js/mc_seo.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_seo == "undefined")
    {
        console.log("MC_seo is not defined");
    }else{
    {if $smarty.get.getlang}
        {if $smarty.get.edit}
        MC_seo.runEdit(baseadmin,getlang,edit);
        {else}
        MC_seo.runList(baseadmin,iso,getlang);
        {/if}
    {elseif !$smarty.get.edit}
        MC_seo.runCharts(baseadmin);
    {/if}
    }
});
</script>