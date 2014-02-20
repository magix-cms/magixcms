{if $smarty.get.tab eq "image"}
<form id="forms_news_edit_image" class="form-inline" method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="n_image">Image :</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2048576" />
        <input type="file" id="n_image" name="n_image" value="" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>
<div id="load_news_img">
    <div id="contener_image"></div>
</div>
{elseif $smarty.get.tab eq "tags"}
<div class="form-group">
    <label for="name_tag">Tags</label>
    <input type="text" class="form-control" id="name_tag" class="tags" value="{$tags}" />
</div>
{elseif $smarty.get.plugin}
    {block name="forms"}{/block}
{else}
<form id="forms_news_edit" method="post" action="">
    <div class="row">
        <div class="form-group">
            <div class="col-lg-4 col-sm-4">
                <label class="radio-inline">
                    <input type="radio" name="published" value="1"{if $published eq 1} checked="checked"{/if} /> {#online#|ucfirst}
                </label>
                <label class="radio-inline">
                    <input type="radio" name="published" value="0"{if $published eq 0} checked="checked"{/if} /> {#offline#|ucfirst}
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-2 col-sm-2">
                <label for="iso">ISO</label>
                <input type="text" class="form-control" id="iso" disabled="disabled" readonly="readonly" size="3" value="{$iso|upper}" />
            </div>
            <div class="col-lg-8 col-sm-8">
                <label for="newslink">URL</label>
                <input type="text" class="form-control" id="newslink" readonly="readonly" size="50" value="" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-sm-8">
            <label for="n_uri">{#url_rewriting#|ucfirst}</label>
            <div class="input-group">
                <input type="text" class="form-control" id="n_uri" name="n_uri" readonly="readonly" size="30" value="{$n_uri}" />
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
                <label for="n_title">{#label_title#|ucfirst} :</label>
                <input type="text" class="form-control" id="n_title" name="n_title" value="{$n_title}" size="50" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-12 col-sm-12">
                <label for="n_content">{#label_content#|ucfirst} :</label>
                <textarea name="n_content" id="n_content" class="form-control mceEditor">{cleanTextarea field=$n_content}</textarea>
            </div>
        </div>
    </div>
    <p class="btn-row">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </p>
</form>
{/if}