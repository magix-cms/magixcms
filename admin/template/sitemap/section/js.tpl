{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_sitemap.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_sitemap == "undefined")
    {
        console.log("MC_sitemap is not defined");
    }else{
        MC_sitemap.run(baseadmin);
    }
});
</script>