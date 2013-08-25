<form id="forms_lang_add" method="post" action="">
    <div class="form-group">
        <label for="iso">ISO *</label>
        {$iso}
    </div>
    <div class="form-group">
        <label for="language">{#name_language#|ucfirst} *</label>
        <input type="text" placeholder="{#name_language#|ucfirst}" class="form-control" id="language" name="language" value="" size="50" />
    </div>
    <div class="form-group">
        <label>{#default_language#|ucfirst} :</label>
        <input type="radio" id="default_lang_0" name="default_lang" class="radio-inline" value="0" checked="checked" /> {#no#|ucfirst}
        <input type="radio" id="default_lang_1" name="default_lang" class="radio-inline" value="1" /> {#yes#|ucfirst}
    </div>
</form>