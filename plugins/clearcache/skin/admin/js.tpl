{script src="/{baseadmin}/min/?f=plugins/{$pluginName}/js/admin.js" type="javascript"}
<script type="text/javascript">
    $(function(){
        if (typeof MC_plugins_clearcache == "undefined")
        {
            console.log("MC_plugins_clearcache is not defined");
        }else{
            MC_plugins_clearcache.run(baseadmin);
        }
    });
</script>