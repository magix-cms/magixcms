<p>
    <a href="#metas" class="btn btn-primary view-metas">
        <span class="fa fa-plus"></span> Ajouter une réécriture
    </a>
</p>
<div class="collapse-metas" id="metas">
    <form id="forms_seo_add" method="post" action="">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                {$select_attribute}
                </div>
                <div class="form-group">
                {$select_level}
                </div>
                <div class="form-group">
                {$select_metas}
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea id="strrewrite" name="strrewrite" class="col-sm-12" rows="2"></textarea>
                </div>
                <ul class="list-inline">
                    <li>
                        <a href="#" id="add-category" class="btn btn-link"><span class="fa fa-plus"></span> {#category#}</a>
                    </li>
                    <li>
                        <a href="#" id="add-subcategory" class="btn btn-link"><span class="fa fa-plus"></span> {#subcategory#}</a>
                    </li>
                    <li>
                        <a href="#" id="add-product" class="btn btn-link"><span class="fa fa-plus"></span> {#products#}</a>
                    </li>
                </ul>
            </div>
        </div>
        <p>
            <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        </p>
    </form>
</div>