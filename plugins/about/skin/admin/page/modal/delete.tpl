<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">{#delete_page#|ucfirst}</h4>
            </div>
            <form id="del_page" class="forms_plugins_cat_rel" method="post" action="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=account&amp;action=delete">
                <div class="modal-body">
                    <p class="alert alert-warning">
                        <span class="fa fa-warning"></span> {#delete_warn#|ucfirst}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{#cancel#|ucfirst}</button>
                    <input type="submit" class="btn btn-primary" value="{#continue#|ucfirst}"/>
                    <input type="hidden" name="delete" id="delete" value=""/>
                </div>
            </form>
        </div>
    </div>
</div>