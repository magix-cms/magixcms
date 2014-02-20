{if $smarty.get.tab eq "image"}
    <form id="forms_catalog_product_image" class="form-inline" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="2048576" />
            <input type="file" id="imgcatalog" name="imgcatalog" value="" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        </div>
    </form>
    <div id="load_catalog_product_img">
        <div id="contener_image"></div>
    </div>
{elseif $smarty.get.tab eq "category"}
<form id="forms_catalog_product_category" class="form-inline" method="post" action="">
    <div class="form-group">
        <select id="idclc" name="idclc" class="form-control">
            {foreach $array_list_category as $key => $value nocache}
                <option value="{$key}">{$value}</option>
            {/foreach}
        </select>
    </div>
    <div class="form-group">
        <select id="idcls" name="idcls" class="form-control">
            <option value="">{#select_subcategory#|ucfirst}</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>
<div id="list_product_category"></div>
{elseif $smarty.get.tab eq "product"}
<div class="row">
    <form id="forms_catalog_product_related" class="form-row" method="post" action="">
        <div class="col-lg-8 col-sm-8">
            <div class="input-group">
                <input class="form-control" id="titleproduct" type="text" value="">
                <span class="input-group-addon">
                    <span class="fa fa-search"></span>
                </span>
            </div>
        </div>
    </form>
</div>
<div id="list_product_rel" class="table-row"></div>
{elseif $smarty.get.tab eq "galery"}
    <form id="forms_catalog_product_galery" class="form-inline" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="2048576" />
            <input type="file" id="imgcatalog" name="imgcatalog" value="" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        </div>
    </form>
    <div id="load_catalog_product_galery"></div>
{elseif $smarty.get.plugin}
{block name="forms"}{/block}
{else}
    <form id="forms_catalog_product_edit" method="post" action="">
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2 col-sm-2">
                    <label for="iso">ISO</label>
                    <input type="text" class="form-control" id="iso" disabled="disabled" readonly="readonly" size="3" value="{$iso|upper}" />
                </div>
                <div class="col-lg-8 col-sm-8">
                    <label for="urlcatalog">{#url_rewriting#|ucfirst}</label>
                    <div class="input-group">
                    <input type="text" class="form-control" id="urlcatalog" name="urlcatalog" readonly="readonly" size="30" value="{$urlcatalog}" />
                    <span class="input-group-addon">
                        <a class="unlocked" href="#">
                            <span class="fa fa-lock"></span>
                        </a>
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-8 col-sm-8">
                    <label for="titlecatalog">{#label_name_product#|ucfirst} :</label>
                    <input type="text" class="form-control" id="titlecatalog" name="titlecatalog" value="{$titlecatalog}" size="50" />
                </div>
                <div class="col-lg-3 col-sm-3">
                    <label for="price">{#label_price#|ucfirst} :</label>
                    <input type="text" class="form-control" id="price" name="price" value="{$price}" size="10" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-12 col-sm-12">
                    <label for="desccatalog" class="inlinelabel">{#label_content#|ucfirst} :</label>
                    <textarea name="desccatalog" id="desccatalog" class="form-control mceEditor">{cleanTextarea field=$desccatalog}</textarea>
                </div>
            </div>
        </div>
        <p class="btn-row">
            <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
        </p>
    </form>
{/if}