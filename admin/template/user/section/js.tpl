{script src="/{baseadmin}/min/?g=charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/mc_user.js" concat={$concat} type="javascript"}
<script type="text/javascript">
$(function(){
    if (typeof MC_user == "undefined")
    {
        console.log("MC_user is not defined");
    }else{
        if($('#list_user').length != 0){
            MC_user.runList(baseadmin,iso);
        }else if($('#forms_user_data_edit').length != 0){
            MC_user.runEdit(baseadmin,edit);
        }else{
            MC_user.runCharts(baseadmin);
        }
    }
});
</script>