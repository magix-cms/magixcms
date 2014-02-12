<div class="row">
    <div class="col-sm-12">
        <h2>{#h2_creating_sitemap#|ucfirst}</h2>
        <div class="col-sm-11">
            <div class="col-sm-3">
                <span class="badge">1</span> Sitemap Index
            </div>
            <div class="col-sm-8">
                <a href="#" class="btn btn-primary" id="sitemap_index">
                    <span class="fa fa-sitemap"></span> {#file_creation#|ucfirst}
                </a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="col-sm-11">
            <div class="col-sm-3">
                <span class="badge badge-inverse">2</span> Sitemap URL
            </div>
            <div class="col-sm-8">
                <form id="forms_sitemap_url_add" class="form-inline" method="post" action="">
                    <div class="form-group">
                        {$select_lang}
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-sm" value="{#send#|ucfirst}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="col-sm-11">
            <div class="col-sm-3">
                <span class="badge label-info">3</span> Sitemap Image
            </div>
            <div class="col-sm-8">
                <form id="forms_sitemap_images_add" class="form-inline" method="post" action="">
                    <div class="form-group">
                        {$select_lang}
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-sm" value="{#send#|ucfirst}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <h2>{#h2_sending_sitemap#|ucfirst}</h2>
        <div class="col-sm-11">
            <span class="col-sm-7">
                <span class="badge">1</span> {#span_googleping#}
            </span>
            <span class="col-sm-2">
                <a href="#" id="pinguer" class="btn btn-sm googleping">
                    <span class="fa fa-lg fa-plus-circle"></span>
                </a>
            </span>
        </div>
        <div class="col-sm-11">
            <span class="col-sm-7">
                <span class="badge badge-inverse">2</span> {#span_googleping_gz#}
            </span>
            <span class="col-sm-2">
                <a href="#" id="compressed" class="btn btn-sm googleping">
                    <span class="fa fa-lg fa-plus-circle"></span>
                </a>
            </span>
        </div>
    </div>
</div>