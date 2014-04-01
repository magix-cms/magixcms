{include file="section/editor.tpl"}
{script src="/{baseadmin}/min/?g=tinymce,charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/tinymce-config.js,{baseadmin}/template/js/mc_home.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    var access = new Array;
    access["view"]="{$access.view}";
    access["add"]="{$access.add}";
    access["edit"]="{$access.edit}";
    access["delete"]="{$access.delete}";
    $(function(){
        if (typeof MC_home == "undefined")
        {
            console.log("MC_home is not defined");
        }else{
            if($('#list_home').length != 0){
                MC_home.runList(baseadmin,iso,access);
            }else if($('#forms_home_edit').length != 0){
                MC_home.runEdit(baseadmin,edit);
            }else{
                MC_home.runCharts(baseadmin);
            }
        }
    });
</script>