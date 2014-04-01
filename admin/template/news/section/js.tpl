{include file="section/editor.tpl"}
{script src="/{baseadmin}/min/?g=tinymce,charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/tinymce-config.js,{baseadmin}/template/js/vendor/jquery.tagsinput.js,{baseadmin}/template/js/mc_news.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    var access = new Array;
    access["view"]="{$access.view}";
    access["add"]="{$access.add}";
    access["edit"]="{$access.edit}";
    access["delete"]="{$access.delete}";
$(function(){
    if (typeof MC_news == "undefined")
    {
        console.log("MC_news is not defined");
    }else{
        {if $smarty.get.getlang}
            {if $smarty.get.edit}
            MC_news.runEdit(baseadmin,iso,getlang,edit);
            {else}
            MC_news.runList(baseadmin,iso,getlang,access);
            {/if}
        {elseif !$smarty.get.edit}
            MC_news.runCharts(baseadmin);
        {/if}
    }
});
</script>