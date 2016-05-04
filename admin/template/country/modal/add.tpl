<div class="modal fade" id="add-country" tabindex="-1" role="dialog" aria-labelledby="addCountry" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addCountry">Ajouter un pays</h4>
            </div>
            <form id="forms_add_country" method="post" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="country">Pays :</label>
                                <select class="form-control" id="country" name="country">
                                    <option value="">{#select_country#}</option>
                                    {foreach $countryTools as $key => $val}
                                        <option value="{$val|lower}" data-iso="{$key|upper}">{#$key#|ucfirst}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="iso">ISO :</label>
                                <input type="text" class="form-control" id="iso" name="iso" value="" size="50" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Ajouter" />
                </div>
            </form>
        </div>
    </div>
</div>