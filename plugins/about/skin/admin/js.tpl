{include file="section/editor.tpl"}
{script src="/{baseadmin}/min/?g=tinymce" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/tinymce-config.js,plugins/{$pluginName}/js/bootstrap2-toggle.min.js,plugins/{$pluginName}/js/admin.js" concat={$concat} type="javascript"}
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