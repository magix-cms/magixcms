<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Supprimer une relation</h4>
            </div>
            <form id="delForm" class="forms_plugins_cat_rel" method="post" action="{$pluginUrl}&amp;getlang={$smarty.get.getlang}&amp;tab=account&amp;action=deleteApi">
                <div class="modal-body">
                    <span class="fa fa-warning"></span> Attention, vous-êtes sur le point de supprimer l'identifiant du compte.
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Continuer"/>
                </div>
            </form>
        </div>
    </div>
</div>