{script src="/{baseadmin}/min/?g=charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f=plugins/{$pluginName}/js/bootstrap2-toggle.min.js,plugins/{$pluginName}/js/admin.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    $(function(){
        if (typeof MC_plugins_about == "undefined")
        {
            console.log("MC_plugins_about is not defined");
        }else{
            MC_plugins_about.run(baseadmin);
        }
    });
</script>