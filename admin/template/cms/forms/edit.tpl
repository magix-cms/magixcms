<form id="forms_cms_edit" method="post" action="">
    <div class="row">
        <div class="form-group">
            <div class="col-lg-2 col-sm-2">
                <label for="iso">ISO</label>
                <input type="text" class="form-control" id="iso" disabled="disabled" readonly="readonly" size="3" value="{$iso|upper}" />
            </div>
            <div class="col-lg-8 col-sm-8">
                <label for="cmslink">URL</label>
                <input type="text" class="form-control" id="cmslink" readonly="readonly" size="50" value="" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-sm-8">
            <label for="uri_page">{#url_rewriting#|ucfirst}</label>
            <div class="input-group">
                <input type="text" class="form-control" id="uri_page" name="uri_page" readonly="readonly" size="30" value="{$uri_page}" />
                <span class="input-group-addon">
                    <a class="unlocked" href="#">
                        <span class="fa fa-lock"></span>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-8 col-sm-8">
                <label for="title_page">{#label_title#|ucfirst} :</label>
                <input type="text" class="form-control" id="title_page" name="title_page" value="{$title_page}" size="50" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-12 col-sm-12">
                <label for="content_page">{#label_content#|ucfirst} :</label>
                <textarea name="content_page" id="content_page" class="form-control mceEditor">{cleanTextarea field=$content_page}</textarea>
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
                <label for="seo_title_page">{#label_title#|ucfirst} :</label>
                <textarea class="form-control" id="seo_title_page" name="seo_title_page" cols="70" rows="3">{$seo_title_page}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-sm-12">
                <label for="seo_desc_page">Description :</label>
                <textarea class="form-control" id="seo_desc_page" name="seo_desc_page" cols="70" rows="3">{$seo_desc_page}</textarea>
            </div>
        </div>
    </div>
    <p>
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </p>
</form>