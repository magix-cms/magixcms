{include file="section/editor.tpl"}
{script src="/{baseadmin}/min/?g=tinymce,charts" concat={$concat} type="javascript"}
{script src="/{baseadmin}/min/?f={baseadmin}/template/js/tinymce-config.js,/libjs/vendor/jquery.relatedselects.min.js,{baseadmin}/template/js/mc_catalog.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    var access = new Array;
    access["view"]="{$access.view}";
    access["add"]="{$access.add}";
    access["edit"]="{$access.edit}";
    access["delete"]="{$access.delete}";
    var section = "{$smarty.get.section}";
    $(function(){
        if (typeof MC_catalog == "undefined")
        {
            console.log("MC_catalog is not defined");
        }else{

            {if $smarty.get.section eq 'category'}
                {if $smarty.get.getlang}
                    {if $smarty.get.edit}
                    MC_catalog.runEditCategory(baseadmin,iso,section,getlang,edit);
                    {else}
                        MC_catalog.runListCategory(baseadmin,iso,section,getlang,access);
                    {/if}
                {/if}
            {elseif $smarty.get.section eq 'subcategory'}
                {if $smarty.get.getlang}
                    {if $smarty.get.edit}
                        MC_catalog.runEditSubcategory(baseadmin,iso,section,getlang,edit);
                    {/if}
                {/if}
            {elseif $smarty.get.section eq 'product'}
                {if $smarty.get.getlang}
                    {if $smarty.get.edit}
                        MC_catalog.runEditProduct(baseadmin,iso,section,getlang,edit);
                    {else}
                        var getpage = "{$smarty.get.page}";
                        MC_catalog.runListProduct(baseadmin,iso,section,getlang,access,getpage);
                {/if}
            {/if}
            {elseif !$smarty.get.section}
                MC_catalog.runCharts(baseadmin);
            {/if}
        }
    });
</script>