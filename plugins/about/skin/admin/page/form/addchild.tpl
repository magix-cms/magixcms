<form action="{$smarty.server.REQUEST_URI}" id="add_child_form" method="post" class="forms_plugins_informations">
    <fieldset>
        <legend>Ajout d'une sous-page</legend>
        <div class="row">
            <div class="form-group col-xs-12 col-sm-2">
                <label for="iso">ISO</label>
                <input id="iso" class="form-control" type="text" value="{$parent.iso|upper}" size="3" readonly="readonly" disabled="disabled">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12">
                <label for="page_title">{#page_title#|ucfirst}&nbsp;:</label>
                <input type="text" class="form-control" id="page_title" name="page_title" placeholder="{#page_title_ph#|ucfirst}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12">
                <label for="page_content">{#page_content#|ucfirst}&nbsp;:</label>
                <textarea name="page_content" id="page_content" class="form-control mceEditor"></textarea>
            </div>
        </div>

        <p>
            <a class="btn btn-default view-metas" href="#metas">
                <span class="fa fa-plus"></span>
                Affiche les metas
            </a>
        </p>
        <div id="metas" class="collapse-metas row">
            <div class="form-group col-xs-12">
                <label for="seo_title_page">{#page_seo_title#|ucfirst}&nbsp;:</label>
                <textarea id="seo_title_page" class="form-control" rows="3" cols="70" name="seo_title_page"></textarea>
            </div>
            <div class="form-group col-xs-12">
                <label for="seo_desc_page">{#page_seo_desc#|ucfirst}&nbsp;:</label>
                <textarea id="seo_desc_page" class="form-control" rows="3" cols="70" name="seo_desc_page"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}" />
                <input type="hidden" name="parent" value="{$parent.id}" />
            </div>
        </div>
    </fieldset>
</form>