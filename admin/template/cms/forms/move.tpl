<form id="forms_cms_move" method="post" action="">
    <div class="row">
        <div class="form-group">
            <div class="col-lg-2 col-sm-2">
                <label for="iso">ISO</label>
                <input type="text" class="form-control" id="iso" disabled="disabled" readonly="readonly" size="3" value="{$iso|upper}" />
            </div>
            <div class="col-lg-8 col-sm-8">
                <label for="title_page">{#label_title#|ucfirst}</label>
                <input type="text" class="form-control" id="title_page" name="title_page" disabled="disabled" readonly="readonly" size="30" value="{$title_page}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-8 col-sm-8">
                <label for="uri_page">URL :</label>
                <input type="text" class="form-control" id="uri_page" name="uri_page" readonly="readonly" size="50" value="{$uri_page}" />
            </div>
            <div class="col-lg-4 col-sm-4">
                <label for="idlang">{#language#|ucfirst} *</label>
                {$selectlang}
            </div>
        </div>
    </div>
    <p class="btn-row">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </p>
</form>