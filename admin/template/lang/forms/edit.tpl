<form id="forms_lang_edit" method="post" action="">
    <div class="row">
        <div class="form-group">
            <div class="col-sm-4">
                <label for="iso">ISO *</label>
                {$iso}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-4">
                <label for="language">{#name_language#|ucfirst} *</label>
                <input type="text" placeholder="{#name_language#|ucfirst}" class="form-control" id="language" name="language" value="{$language}" size="50" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-4">
                <p>{#default_language#|ucfirst} :</p>
                {if $default_lang eq '1'}
                <label class="radio-inline">
                    <input type="radio" id="default_lang_0" name="default_lang" class="radio" value="0" /> {#no#|ucfirst}
                </label>
                <label class="radio-inline">
                    <input type="radio" id="default_lang_1" name="default_lang" class="radio" value="1" checked="checked" /> {#yes#|ucfirst}
                </label>
                {else}
                <label class="radio-inline">
                    <input type="radio" id="default_lang_0" name="default_lang" class="radio" value="0" checked="checked" /> {#no#|ucfirst}
                </label>
                <label class="radio-inline">
                    <input type="radio" id="default_lang_1" name="default_lang" class="radio" value="1" /> {#yes#|ucfirst}
                </label>
                {/if}
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{#send#|ucfirst}" />
    </div>
</form>