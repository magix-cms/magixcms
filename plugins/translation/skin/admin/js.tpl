{script src="/{baseadmin}/min/?f=plugins/{$pluginName}/js/admin.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    var section = "{$smarty.get.section}";
    var plugin = "{$smarty.get.pluginame}";
    $(function(){
        if (typeof MC_plugins_translation == "undefined")
        {
            console.log("MC_plugins_translation is not defined");
        }else{
        {if $smarty.get.getlang}
            {if $smarty.get.section}
                MC_plugins_translation.runEdit(baseadmin,getlang,section,plugin);
            {/if}
        {/if}
        }
    });
</script>