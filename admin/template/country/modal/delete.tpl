<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="deleteModalData">{#delete_country#|ucfirst}</h4>
            </div>
            <form id="del_country" class="" method="post" action="">
                <div class="modal-body">
                    <p class="alert alert-warning">
                        <span class="fa fa-warning"></span> {#delete_warn#|ucfirst}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{#cancel#|ucfirst}</button>
                    <input type="submit" class="btn btn-primary" value="{#continue#|ucfirst}"/>
                    <input type="hidden" name="delete_country" id="delete_country" value=""/>
                </div>
            </form>
        </div>
    </div>
</div>