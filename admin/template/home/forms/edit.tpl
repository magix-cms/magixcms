<form id="forms_home_edit" method="post" action="">
    <div class="row">
        <div class="form-group">
            <div class="col-lg-2">
                <label for="iso">ISO</label>
                <input type="text" class="form-control" id="iso" disabled="disabled" readonly="readonly" size="3" value="{$iso|upper}" />
            </div>
            <div class="col-lg-8">
                <label for="subject">{#label_title#|ucfirst} *:</label>
                <input type="text" class="form-control" id="subject" name="subject" value="{$subject}" size="50" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-12">
                <label for="content">{#label_content#|ucfirst} :</label>
                <textarea name="content" id="content" class="form-control mceEditor">{cleanTextarea field=$content}</textarea>
            </div>
        </div>
    </div>
    <p>
        <a href="#metas" class="btn btn-default view-metas">
            <span class="fa fa-plus"></span> {#display_metas#|ucfirst}
        </a>
    </p>
    <div class="collapse-metas row" id="metas">
        <div class="form-group">
            <div class="col-lg-12 col-sm-12">
                <label for="metatitle">{#label_title#|ucfirst} :</label>
                <textarea class="form-control" id="metatitle" name="metatitle" cols="70" rows="3">{$metatitle}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-sm-12">
                <label for="metadescription">Description :</label>
                <textarea class="form-control" id="metadescription" name="metadescription" cols="70" rows="3">{$metadescription}</textarea>
            </div>
        </div>
    </div>
    <p>
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </p>
</form>