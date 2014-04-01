{include file="section/editor.tpl"}
{script src="/{baseadmin}/min/?g=tinymce,charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/tinymce-config.js,{baseadmin}/template/js/mc_pages.js" concat={$concat} type="javascript"}
<script type="text/javascript">
{if $smarty.get.get_page_p}
var getParent = "{$smarty.get.get_page_p}";
{/if}
var access = new Array;
access["view"]="{$access.view}";
access["add"]="{$access.add}";
access["edit"]="{$access.edit}";
access["delete"]="{$access.delete}";
$(function(){
    if (typeof MC_pages == "undefined")
    {
        console.log("MC_pages is not defined");
    }else{
        {if $smarty.get.getlang}
            {if $smarty.get.action eq 'edit'}
                MC_pages.runEdit(baseadmin,getlang,edit);
            {elseif $smarty.get.get_page_p}
                MC_pages.runChild(baseadmin,iso,getlang,getParent,access);
            {elseif $smarty.get.action eq 'move'}
                MC_pages.runMove(baseadmin,getlang,edit);
            {else}
                MC_pages.runParents(baseadmin,iso,getlang,access);
            {/if}
        {elseif !$smarty.get.edit}
            MC_pages.runCharts(baseadmin);
        {/if}
    }
});
</script>