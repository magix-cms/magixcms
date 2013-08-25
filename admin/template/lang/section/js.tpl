{script src="/{baseadmin}/min/?g=charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_lang.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_lang == "undefined")
    {
        console.log("MC_lang is not defined");
    }else{
        if($('#list_lang').length != 0){
            MC_lang.runList(baseadmin,iso);
        }else if($('#forms_lang_edit').length != 0){
            MC_lang.runEdit(baseadmin,edit);
        }else{
            MC_lang.runCharts(baseadmin);
        }
    }
});
</script>