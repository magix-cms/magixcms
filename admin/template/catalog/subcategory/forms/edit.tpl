{if $smarty.get.tab eq "image"}
    <form id="forms_catalog_subcategory_image" class="form-inline" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="img_s">Image :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2048576" />
            <input type="file" id="img_s" name="img_s" value="" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        </div>
    </form>
    <div id="load_catalog_subcategory_img">
        <div id="contener_image"></div>
    </div>
{elseif $smarty.get.tab eq "product"}
    <div id="list_subcategory_product" class="table-row"></div>
{elseif $smarty.get.plugin}
    {block name="forms"}{/block}
{else}
    <form id="forms_catalog_subcategory_edit" method="post" action="">
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2 col-sm-2">
                    <label for="iso">ISO</label>
                    <input type="text" class="form-control" id="iso" disabled="disabled" readonly="readonly" size="3" value="{$iso|upper}" />
                </div>
                <div class="col-lg-8 col-sm-8">
                    <label for="subcategorylink">URL</label>
                    <input type="text" class="form-control" id="subcategorylink" readonly="readonly" size="50" value="" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-8">
                <label for="pathclibelle">{#url_rewriting#|ucfirst}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="pathslibelle" name="pathslibelle" readonly="readonly" size="30" value="{$pathslibelle}" />
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
                    <label for="clibelle">{#label_name_subcategory#|ucfirst} :</label>
                    <input type="text" class="form-control" id="slibelle" name="slibelle" value="{$slibelle}" size="50" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-12 col-sm-12">
                    <label for="s_content" class="inlinelabel">{#label_content#|ucfirst} :</label>
                    <textarea name="s_content" id="s_content" class="form-control mceEditor">{cleanTextarea field=$s_content}</textarea>
                </div>
            </div>
        </div>
        <p class="btn-row">
            <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        </p>
    </form>
{/if}