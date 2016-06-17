{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_webservice.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_webservice == "undefined")
    {
        console.log("MC_webservice is not defined");
    }else{
        MC_webservice.run(baseadmin);
    }
});
</script>