{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_country.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_country == "undefined")
    {
        console.log("MC_country is not defined");
    }else{
        MC_country.run(baseadmin);
    }
});
</script>