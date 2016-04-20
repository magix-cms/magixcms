{*{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_country.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_country == "undefined")
    {
        console.log("MC_country is not defined");
    }else{
        if($('#list_country').length != 0){
            //MC_country.runList(baseadmin,iso);
        }
    }
});
</script>*}